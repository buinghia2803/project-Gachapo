# base image
FROM node:12-alpine as builder

WORKDIR /app

COPY . .

RUN yarn install \
  --prefer-offline \
  --frozen-lockfile \
  --non-interactive \
  --production=false

# RUN yarn build

RUN rm -rf node_modules && \
  NODE_ENV=local yarn install \
  --prefer-offline \
  --pure-lockfile \
  --non-interactive \
  --production=false

FROM node:12-alpine

WORKDIR /app

COPY --from=builder /app  .

# ENV HOST 0.0.0.0
EXPOSE 3000

CMD ["yarn", "dev" ]