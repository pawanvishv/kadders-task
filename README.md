# kadders-task

# 1. Stop all containers
docker-compose down

# 2. Remove MySQL volume (this will delete existing data!)
docker volume rm kadders_mysql-data

# 3. Start fresh
docker-compose up -d --build

# 4. Wait for MySQL to be ready (check logs)
docker-compose logs -f mysql

# 5. Clear Laravel cache
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan cache:clear

# 6. Run migrations
docker-compose exec app php artisan migrate


# 1. Stop containers
docker-compose down

# 2. Start with new config
docker-compose up -d

# 3. Fix authentication for existing user
docker-compose exec mysql mysql -uroot -proot -e "ALTER USER 'kadders'@'%' IDENTIFIED WITH mysql_native_password BY 'kadders'; FLUSH PRIVILEGES;"

# 4. Test connection
docker-compose exec app php artisan migrate
