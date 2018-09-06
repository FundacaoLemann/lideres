while [ true ]; do
    wp --url=$MATCH_SITE_URL --path=/var/www/html/ do-matches
    sleep  60
done
