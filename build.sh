cd build
git clone https://github.com/kaff/studiomanager.git b0
git checkout b8s
cd b0
docker-compose up -d
docker-compose exec php bash -c "composer install --no-dev"
docker-compose down
docker build -f dockerfile-ci -t studio-manager-ci:b1 .
