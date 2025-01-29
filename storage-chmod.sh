sudo chown -R www-data:www-data storage
sudo chown -R www-data:www-data storage/logs
sudo chown -R $USER:www-data storage
sudo chown -R $USER:www-data bootstrap/cache
sudo chmod -R 775 storage
sudo chmod -R 775 bootstrap/cache
