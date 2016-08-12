<?php
	namespace BigTree;
	
	/**
	 * @global array $bigtree
	 */
	
	if (!$this->Value && isset($this->Settings["default_now"]) && $this->Settings["default_now"]) {
		$this->Value = date($bigtree["config"]["date_format"]." h:i a");
	} elseif ($this->Value && $this->Value != "0000-00-00 00:00:00") {
		$this->Value = date($bigtree["config"]["date_format"]." h:i a",strtotime($this->Value));
	} else {
		$this->Value = "";
	}
	
	// We draw the picker inline for callouts
	if (defined("BIGTREE_CALLOUT_RESOURCES")) {
		// Process hour/minute
		if ($this->Value) {
			$date = \DateTime::createFromFormat($bigtree["config"]["date_format"]." h:i a",$this->Value);
			$hour = $date->format("H");
			$minute = $date->format("i");
		} else {
			$hour = "0";
			$minute = "0";
		}
?>
<input type="hidden" name="<?=$this->Key?>" value="<?=$this->Value?>" />
<div class="date_time_picker_inline" data-date="<?=$this->Value?>" data-hour="<?=$hour?>" data-minute="<?=$minute?>"></div>
<div class="date_picker_clear">Clear Date</div>
<?php
	} else {
?>
<input type="text" tabindex="<?=$this->TabIndex?>" name="<?=$this->Key?>" value="<?=$this->Value?>" autocomplete="off" id="<?=$this->ID?>" class="date_time_picker<?php if ($this->Required) { ?> required<?php } ?>" />
<span class="icon_small icon_small_calendar date_picker_icon"></span>
<?php
	}
?>