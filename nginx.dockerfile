FROM nginx:stable-alpine AS base

COPY server/nginx/default.conf /etc/nginx/conf.d/default.conf
RUN mkdir -p /var/www/html/be /var/www/html/fe

FROM base AS runtime
USER nginx
EXPOSE 80
HEALTHCHECK --interval=30s --timeout=3s --start-period=10s --retries=3 \
    CMD wget --no-verbose --tries=1 --spider http://localhost:80/ || exit 1
CMD ["nginx", "-g", "daemon off;"]
