<?php if ($session->role == '1' || $session->role == '4') { ?>
<a href="<?php echo base_url();?>/admin/getCapturedDataMolds" target="_blank">Download Data Molds</a>
<br><br>    
<?php }?>
<?php if ($session->role == '1' || $session->role = '5') { ?>
<a href="<?php echo base_url();?>/admin/getCapturedDataMachines" target="_blank">Download Data Maintenance</a>
<?php }?>