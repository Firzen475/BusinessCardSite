#!/usr/bin/env bash
_init_ssh(){
        /usr/bin/ssh-keygen -A
        cp /.ssh/* /root/.ssh/
        chmod 640 /root/.ssh/id_rsa.pub
        chmod 600 /root/.ssh/id_rsa
        chmod 640 /root/.ssh/authorized_keys
        /etc/init.d/ssh start
}

_save_credentials(){
	echo "$PGADMIN_SETUP_EMAIL:$PGADMIN_SETUP_PASSWORD" > /credentials
	chmod 600 /credentials
}

if [ -f /pgadmin4/passfile ]; then
    sed -i "s/PG_PASSWORD/$PG_PASSWORD/g" /pgadmin4/passfile ;
fi

if [ ! -f /pgadmin4/config/pgadmin4.db ]; then
    if ([ -z "${PGADMIN_DEFAULT_EMAIL}" ]) || ( [ -z "${PGADMIN_DEFAULT_PASSWORD}" ] && [ ! -n "${PGADMIN_DEFAULT_PASSWORD_FILE}" ] ); then
        echo 'You need to define the PGADMIN_DEFAULT_EMAIL and PGADMIN_DEFAULT_PASSWORD or PGADMIN_DEFAULT_PASSWORD_FILE environment variables.'
        exit 1
    fi
    echo ${PGADMIN_DEFAULT_EMAIL} | grep -E "^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$" > /dev/null
    if [ $? -ne 0 ]; then
        echo "'${PGADMIN_DEFAULT_EMAIL}' does not appear to be a valid email address. Please reset the PGADMIN_DEFAULT_EMAIL environment variable and try again."
        exit 1
    fi

    # Set the default username and password in a
    # backwards compatible way
    export PGADMIN_SETUP_EMAIL=${PGADMIN_DEFAULT_EMAIL}
    export PGADMIN_SETUP_PASSWORD=${PGADMIN_DEFAULT_PASSWORD}
    export PGADMIN_SERVER_JSON_FILE=${PGADMIN_SERVER_JSON_FILE:-/pgadmin4/servers.json}

    # Initialize DB before starting Gunicorn
    # Importing pgadmin4 (from this script) is enough
    python3 /pgadmin4/run_pgadmin.py

    if [ -f "${PGADMIN_SERVER_JSON_FILE}" ]; then
        python3 /pgadmin4/setup.py --load-servers "${PGADMIN_SERVER_JSON_FILE}" --user ${PGADMIN_DEFAULT_EMAIL} 
    fi
fi

echo "id $(id -u)"
echo "bash_source $BASH_SOURCE"
echo "a $@"

#if [ "$(id -u)" = '0' ]; then
#	echo "bash_source $BASH_SOURCE"
#	echo "a $@"
        _init_ssh
	_save_credentials
#        echo "$POSTGRES_USER:$POSTGRES_PASSWORD" > /credentials
#        # then restart script as postgres user
#        exec gosu pgadmin "$BASH_SOURCE"
#fi

echo $PGADMIN_SETUP_EMAIL
echo $PGADMIN_SETUP_PASSWORD
echo $PGADMIN_SERVER_JSON_FILE
#find / -name pg_dump
#ls -all /usr/local/lib/python3.8/dist-packages/pgadmin4/
#ls -all /usr/local/pgsql/
python3 /pgadmin4/pgAdmin4.py

#find /usr/local/lib/ -type f -name "pgAdmin4.py" -exec python3  {} \;
#python3 /usr/local/lib/python3.8/dist-packages/pgadmin4/setup.py --load-servers "/pgadmin/servers.json" --user ${PGADMIN_DEFAULT_EMAIL} ;
