#!/bin/sh

: ${ENV_SECRETS_DIR:=/run/secrets}

function env_secret_debug() {
    if [ ! -z "$ENV_SECRETS_DEBUG" ]; then
        echo -e "\033[1m$@\033[0m"
    fi
}

function set_env_configs(){
    set -e
    local secret_name=$SECRET_NAME
    local secret_path="${ENV_SECRETS_DIR}/${secret_name}"
    if [[ -f "$secret_path" ]]; then
        echo "installing base config..."
        install -m 644 -o www-data -g www-data "$secret_path" .env
    else
        echo "env secret file not found, skipping env"
    fi

    if [ ! -z "$ENV_SECRETS_DEBUG" ]; then
        echo -e "\n\033[1mExpanded environment variables\033[0m"
        printenv
    fi
}

function prepare(){
    set_env_configs
    su www-data -s /bin/ash -c 'composer dump-autoload --no-interaction --optimize'
    echo "🎬 Clearing configuration entries..."
    su www-data -s /bin/ash -c 'php artisan storage:link'
    su www-data -s /bin/ash -c 'php artisan optimize:clear'
    echo "Clearing configuration done!"
}

function wait_for_web(){
    until curl http://webserver; do
        >&2 echo "Waiting for webserver become up..."
        sleep 10s
    done
    echo "webserver is up!"
}

function launch_web(){
    prepare
    echo "Running Webserver ..."
    supervisord -c /etc/supervisor.d/laravel.conf
}

function launch_job(){
    prepare
    wait_for_web
    echo "Running Queue Jobs ..."
    su www-data -s /bin/ash -c 'php artisan queue:work --tries=3 --delay=10s'
    EXCODE=$?
    echo "Stopping Jobs: (exit code $EXCODE)"
    exit $EXCODE
}

function launch_cron(){
    prepare
    wait_for_web
    echo "Running CRON..."
    set -e
    while true;
    do
        su www-data -s /bin/ash -c 'echo "Executing cron at $(date)" > /var/www/html/storage/logs/cron.log'
        su www-data -s /bin/ash -c 'php artisan schedule:run >> /var/www/html/storage/logs/cron.log 2>&1'
        sleep 60s
    done
}

function launch_cli(){
    set_env_secrets
    su www-data -s /bin/ash -c 'composer dump-autoload --no-interaction --optimize'
    $@
}

if [ ! -z "${CONTAINER_ROLE}" ]; then
    case "${CONTAINER_ROLE}" in
        webserver)
            launch_web
            ;;
        job)
            launch_job
            ;;
        cron)
            launch_cron
            ;;
        cli)
            launch_cli $@
            ;;
        *)
            echo "Invalid CONTAINER_ROLE, ${CONTAINER_ROLE}"
            exit 1
    esac
else
    echo "Please set CONTAINER_ROLE"
    exit 2
fi
