while [ true ]; do
    wp --path=/var/www/html/ do-matches
    sleep  60
done
