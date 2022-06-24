find ./ -type f -exec sed -i -e 's|Disciple_Tools_Groups_Card|Disciple_Tools_Groups_Card|g' {} \;
find ./ -type f -exec sed -i -e 's|disciple_tools_groups_card|disciple_tools_groups_card|g' {} \;
find ./ -type f -exec sed -i -e 's|disciple-tools-groups-card|disciple-tools-groups-card|g' {} \;
find ./ -type f -exec sed -i -e 's|starter_post_type|starter_post_type|g' {} \;
find ./ -type f -exec sed -i -e 's|Groups Card|Groups Card|g' {} \;
mv disciple-tools-groups-card.php disciple-tools-groups-card.php
rm .rename.sh
