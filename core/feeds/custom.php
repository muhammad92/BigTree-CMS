<?php
	namespace BigTree;

	$sort = $feed["options"]["sort"] ? $feed["options"]["sort"] : "id DESC";
	$limit = $feed["options"]["limit"] ? $feed["options"]["limit"] : "15";
	$query = SQL::query("SELECT * FROM `".$feed["table"]."` ORDER BY $sort LIMIT $limit");
?><feed>
	<?php
		while ($item = $query->fetch()) {
			foreach ($item as $key => $val) {
				$array_val = @json_decode($val,true);

				if (is_array($array_val)) {
					$item[$key] = Link::decodeArray($array_val);
				} else {
					$item[$key] = $cms->replaceInternalPageLinks($val);
				}
			}
	?>
	<item>
		<?php
			foreach ($feed["fields"] as $key => $options) {
				$value = $item[$key];
				if ($options["parser"]) {
					$value = Module::runParser($item,$value,$options["parser"]);
				}

				// If there's a title, use it for a key
				if ($options["title"]) {
					$key = str_replace(" ","",$options["title"]);
				}
		?>
		<<?=$key?>><![CDATA[<?=$value?>]]></<?=$key?>>
		<?php
			}
		?>
	</item>
	<?php
		}
	?>
</feed>