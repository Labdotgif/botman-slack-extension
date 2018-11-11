#!/bin/bash

# Identify on Gitlab registry to push black-hole images
docker login -u gitlab-ci-token -p $CI_BUILD_TOKEN registry.gitlab.com

docker build -t registry.gitlab.com/dividotgif/botman-slack-extension:latest -f "./resources/docker/Dockerfile" .
docker push registry.gitlab.com/dividotgif/botman-slack-extension:latest
