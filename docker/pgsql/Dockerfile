#
# NOTE: THIS DOCKERFILE IS GENERATED VIA "apply-templates.sh"
#
# PLEASE DO NOT EDIT IT DIRECTLY.
#

FROM ubuntu:20.04 as pgsql

# Переменные
ENV PGDATA /var/lib/postgresql/data
ARG SHEDULE="0 */1 * * *"
ENV SHEDULE $SHEDULE

ARG TZ=Europe/Moscow
ENV TZ $TZ
ARG LANG=en_US
ENV LANG $LANG
ENV LANGUAGE $LANG

ARG PG_MAJOR=12
ENV PG_MAJOR $PG_MAJOR
ENV PATH $PATH:/usr/lib/postgresql/$PG_MAJOR/bin

# Утилиты
RUN apt update && apt install -y --no-install-recommends wget ca-certificates gnupg2 openssh-server gosu

# Создание пользователей и директории
# Папка хранения базы, оффицеалы рекомендуют монтировать во внешнее хранилище
#       usermod -a -G ssl-cert postgres; \
RUN set -eux; \
	groupadd -r postgres --gid=999; \
	useradd -r -g postgres --uid=999 --home-dir=/var/lib/postgresql --shell=/bin/bash postgres; \
	mkdir -p /var/lib/postgresql/ && chown -R postgres:postgres /var/lib/postgresql/ \
	&& mkdir -p /var/run/postgresql && chown -R postgres:postgres /var/run/postgresql && chmod 2777 /var/run/postgresql \
	&& mkdir -p "$PGDATA" && chown -R postgres:postgres "$PGDATA" && chmod 777 "$PGDATA" \
	&& mkdir /docker-entrypoint-initdb.d \
	&& mkdir /BACKUP 
#        && mkdir /cron && chmod 777 /cron \
#	&& echo "${SHEDULE} chmod +x /cron/run.sh && /bin/bash /cron/run.sh" \
#	&& echo "${SHEDULE} chmod +x /cron/run.sh && /bin/bash /cron/run.sh" >> /mycron | crontab -u root /mycron

# Настройка openssh-server
RUN sed -i 's/PermitRootLogin prohibit-password/PermitRootLogin yes/' /etc/ssh/sshd_config \
        && mkdir /run/sshd \
        && ssh-keygen -A \
#	&& chmod 640 /etc/ssh/ssh_host_* \
	&& sed -i -r "s:#HostKey:HostKey:" /etc/ssh/sshd_config \
        && mkdir -p /.ssh/ \
#        && chmod 650 /.ssh/ \
        && mkdir -p /root/.ssh/ 
#	&& chmod 700 /var/lib/postgresql/.ssh/ \
#        && chown postgres:postgres /var/lib/postgresql/.ssh/ 
#	&& chown -R postgres. /etc/ssh/


#Установка локали
RUN set -eux; \
	apt update && apt-get install -yq --no-install-recommends locales && \
	localedef -i $LANG -c -f UTF-8 -A /usr/share/locale/locale.alias $LANG.UTF-8 && \
	apt install -yq  tzdata 
ENV LANG $LANG.utf8
ENV LANGUAGE $LANG

# Установка pgsql
RUN set -eux; \
	sh -c 'echo "deb http://apt.postgresql.org/pub/repos/apt $(cat /etc/os-release | grep  UBUNTU_CODENAME= | sed 's/UBUNTU_CODENAME=//g')-pgdg main" > /etc/apt/sources.list.d/pgdg.list' \
	&& wget --quiet -O - https://www.postgresql.org/media/keys/ACCC4CF8.asc | apt-key add - \
	&& apt update \
	&& apt -y install --no-install-recommends postgresql-$PG_MAJOR postgresql-common \
	&& rm -rf /var/lib/apt/lists/* \
	&& apt purge -y --auto-remove; \
	rm -rf /etc/apt/sources.list.d/temp.list; \
	usermod -a -G ssl-cert postgres; \
#	usermod -a -G crontab postgres; \
	usermod -a -G root postgres; \
#  echo "postgres   ALL= NOPASSWD: /var/lib/postgresql/start_cron.sh" >> /etc/sudoers; \
#  echo "/etc/init.d/cron start" > /var/lib/postgresql/start_cron.sh; \
#  chmod +x /var/lib/postgresql/start_cron.sh; \
#  echo "postgres   ALL= NOPASSWD: /var/lib/postgresql/start_ssh.sh" >> /etc/sudoers; \
#  echo "/usr/bin/ssh-keygen -A" > /var/lib/postgresql/start_ssh.sh; \
#  echo "/etc/init.d/ssh start" >> /var/lib/postgresql/start_ssh.sh; \
#  chmod +x /var/lib/postgresql/start_ssh.sh; \
#  echo "postgres   ALL= NOPASSWD: /root/creditals.sh" >> /etc/sudoers; \
#  echo 'mv /var/lib/postgresql/creditals /root/' >> /root/creditals.sh; \
#  echo 'chmod 600 /root/creditals' >> /root/creditals.sh; \
#  echo 'unset POSTGRES_USER' >> /root/creditals.sh; \
#  echo 'unset POSTGRES_PASSWORD' >> /root/creditals.sh; \ 
#  chmod +x /root/creditals.sh; \
	postgres --version

#Получение логина и пароля по ssh (не безопасно!)
#RUN touch /credentials \
#	&& chown postgres:postgres /credentials

#RUN chmod 650 /root/
#RUN mkdir /root/.ssh/
#RUN chmod 650 /root/.ssh/
#RUN /usr/bin/ssh-keygen -A
#RUN chmod 640 /etc/ssh/ssh_host_*
#RUN sed -i -r "s:#HostKey:HostKey:" /etc/ssh/sshd_config

COPY entrypoint.sh /usr/local/bin/
COPY postgresql.conf /var/lib/postgresql/
#COPY authorized_keys /var/lib/postgresql/.ssh/
#RUN chown postgres:postgres /var/lib/postgresql/.ssh/authorized_keys
#RUN chmod 640 /var/lib/postgresql/.ssh/authorized_keys
#RUN mkdir /var/lib/postgresql/.ssh/ 
#RUN chown -R postgres:postgres /var/lib/postgresql/.ssh/
#RUN chmod 700 /var/lib/postgresql/.ssh/
#RUN chmod 755 /var/lib/postgresql/.ssh/*
VOLUME /var/lib/postgresql/data /docker-entrypoint-initdb.d /BACKUP/ /.ssh/

#USER postgres

ENTRYPOINT ["entrypoint.sh"]

# Ознакомиться
# We set the default STOPSIGNAL to SIGINT, which corresponds to what PostgreSQL
# calls "Fast Shutdown mode" wherein new connections are disallowed and any
# in-progress transactions are aborted, allowing PostgreSQL to stop cleanly and
# flush tables to disk, which is the best compromise available to avoid data
# corruption.
#
# Users who know their applications do not keep open long-lived idle connections
# may way to use a value of SIGTERM instead, which corresponds to "Smart
# Shutdown mode" in which any existing sessions are allowed to finish and the
# server stops when all sessions are terminated.
#
# See https://www.postgresql.org/docs/12/server-shutdown.html for more details
# about available PostgreSQL server shutdown signals.
#
# See also https://www.postgresql.org/docs/12/server-start.html for further
# justification of this as the default value, namely that the example (and
# shipped) systemd service files use the "Fast Shutdown mode" for service
# termination.
#
STOPSIGNAL SIGINT
#
# An additional setting that is recommended for all users regardless of this
# value is the runtime "--stop-timeout" (or your orchestrator/runtime's
# equivalent) for controlling how long to wait between sending the defined
# STOPSIGNAL and sending SIGKILL (which is likely to cause data corruption).
#
# The default in most runtimes (such as Docker) is 10 seconds, and the
# documentation at https://www.postgresql.org/docs/12/server-start.html notes
# that even 90 seconds may not be long enough in many instances.

EXPOSE 5432
CMD [ "postgres", "-c", "config_file=/var/lib/postgresql/postgresql.conf" ] 
