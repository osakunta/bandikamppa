NAME   := osakunta/bandikamppa
TAG    := $$(git log -1 --pretty=%h)
IMAGE  := ${NAME}:${TAG}
LATEST := ${NAME}:latest
EXEC   := bandikamppa

docker-build:
	sudo docker build -t ${IMAGE} .
	sudo docker tag ${IMAGE} ${LATEST}

docker-run:
	sudo docker run -it --name ${EXEC} ${LATEST}

docker-rm:
	sudo docker rm ${EXEC}

docker-push:
	sudo docker push ${NAME}

docker-sh:
	sudo docker exec -it ${EXEC} /bin/sh
