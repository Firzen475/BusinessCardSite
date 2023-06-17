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

#Установка ftp и ssh
RUN set -eux; \
	apt-get update && apt-get -y install vsftpd openssh-server whois \
	&& mkdir /share/ \
	&& mkdir -p /.ssh/ \
	&& mkdir -p /root/.ssh/ \
	&& mkdir -p /root/ssl/

VOLUME /share/ /.ssh/ /root/ssl/

COPY entrypoint.sh healthcheck.sh .users /root/
COPY vsftpd.conf /etc/vsftpd.conf

RUN chmod +x /root/entrypoint.sh \
	&& chmod +x /root/healthcheck.sh
EXPOSE 20 21
ENTRYPOINT ["/root/entrypoint.sh"]



