FROM php:8.0-fpm-alpine
COPY crontab /cron-tasks
RUN touch /var/log/cron.log
RUN chown www-data:www-data /var/log/cron.log
RUN /usr/bin/crontab -u www-data /cron-tasks
CMD ["crond", "-f", "-l", "8"]
