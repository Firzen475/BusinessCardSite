FROM ubuntu:20.04 as cron

# Переменные
ARG TZ=Europe/Moscow
ENV TZ $TZ
ARG LANG=en_US
ENV LANG $LANG
ENV LANGUAGE $LANG

#Установка локали
RUN set -eux; \
        apt update && apt-get install -yq --no-install-recommends locales \
        && localedef -i $LANG -c -f UTF-8 -A /usr/share/locale/locale.alias $LANG.UTF-8 \
        && apt install -yq  tzdata
ENV LANG $LANG.utf8
ENV LANGUAGE $LANG

#Установка cron и ssh
RUN set -eux; \
	apt-get update && apt-get -y install cron openssh-client \
	&& mkdir /cron/ \
	&& mkdir -p /.ssh/ \
	&& mkdir -p /root/.ssh/

VOLUME /cron/ /.ssh/

COPY entrypoint.sh /root/

RUN chmod +x /root/entrypoint.sh

ENTRYPOINT ["/root/entrypoint.sh"]



