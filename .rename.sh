find ./ -type f -exec sed -i -e 's|Disciple_Tools_Groups_Tile|Disciple_Tools_Groups_Tile|g' {} \;
find ./ -type f -exec sed -i -e 's|disciple_tools_groups_tile|disciple_tools_groups_tile|g' {} \;
find ./ -type f -exec sed -i -e 's|disciple-tools-groups-tile|disciple-tools-groups-tile|g' {} \;
find ./ -type f -exec sed -i -e 's|starter_post_type|starter_post_type|g' {} \;
find ./ -type f -exec sed -i -e 's|Groups Tile|Groups Tile|g' {} \;
mv disciple-tools-groups-tile.php disciple-tools-groups-tile.php
rm .rename.sh
