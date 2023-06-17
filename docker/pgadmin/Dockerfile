FROM ubuntu:20.04 as pgadmin

# Установка времени
ARG TZ Europe/Moscow
ENV TZ $TZ
RUN apt update && apt install --no-install-recommends -yq  tzdata 

# Сборка и установка
ARG PGADMIN_VERSION=6.12
ENV PGADMIN_VERSION $PGADMIN_VERSION
ENV PYTHONDONTWRITEBYTECODE=1
RUN set -eux; \
	apt update; \
	apt install -y python3-pip \
	&& pip install https://ftp.postgresql.org/pub/pgadmin/pgadmin4/v${PGADMIN_VERSION}/pip/pgadmin4-${PGADMIN_VERSION}-py3-none-any.whl  \
	&& pip install -U 'flask<2.2.0'
RUN find /usr/local/lib/ -type d -name "dist-packages" -exec mv --force {}/pgadmin4/ /  \;
RUN set -eux; \
	apt update; \
	apt install -y python3 postgresql-client curl gosu openssh-server 

# Настройка openssh-server
RUN sed -i 's/PermitRootLogin prohibit-password/PermitRootLogin yes/' /etc/ssh/sshd_config \
        && mkdir /run/sshd \
        && ssh-keygen -A \
        && sed -i -r "s:#HostKey:HostKey:" /etc/ssh/sshd_config \
        && mkdir -p /.ssh/ \
        && mkdir -p /root/.ssh/

# Настройка прав
RUN addgroup --gid 1000 pgadmin \
	&& useradd --no-create-home --home-dir /pgadmin4 --shell /sbin/nologin --uid 1000 --gid pgadmin pgadmin \
	&& mkdir -p /pgadmin4/config \
	&& mkdir -p /var/lib/pgadmin/ \
	&& mkdir -p /var/log/pgadmin/ \
	&& chown -R 1000:1000 /pgadmin4/ \
	&& chown -R 1000:1000 /var/lib/pgadmin/ \
	&& chown -R 1000:1000 /var/log/pgadmin/ 

COPY entrypoint.sh config_distro.py run_pgadmin.py servers.json passfile /pgadmin4/
ENV PATH="${PATH}:/pgadmin4/"

VOLUME /.ssh/

EXPOSE 5050
ENTRYPOINT ["/pgadmin4/entrypoint.sh"]
