#!/bin/bash


su - postgres -c "/usr/lib/postgresql/$PG_VERSION/bin/postgres -D /var/lib/postgresql/$PG_VERSION/main -c config_file=/etc/postgresql/$PG_VERSION/main/postgresql.conf"
#su - postgres -c "/usr/lib/postgresql/$PG_VERSION/bin/postgres -D"
#sleep 5
echo $FIRST_START
#if [[ $FIRST_START == "true" ]]; then
#        echo $PG_VERSION
#        su - postgres -c "/bin/psql -U postgres -d postgres /l"
#fi


#printenv PG_PASSWORD
