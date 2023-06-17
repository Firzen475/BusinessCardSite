#!/usr/bin/env bash

_init_ssh_client(){
	cp /.ssh/id_rsa /root/.ssh/
	chmod 600 /root/.ssh/id_rsa
}
_init_ssh_client
/etc/init.d/cron start
touch /var/log/cron.log
if [ -f /cron/cronjob ]; then
	crontab -u root /cron/cronjob
	crontab -l
fi
#chmod +x /cron/*.sh
echo "Стоит проверить права на выполнение скриптов!"
ls -all /cron/
echo "/////////////////////////////////////////////"
tail -f /var/log/cron.log
