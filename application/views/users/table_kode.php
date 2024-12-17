	<?php defined('__PUDINTEA__') OR exit('No direct script access allowed'); ?>
	<script type="text/javascript">
			$(document).ready( function () {
				var token = "<?=$this->security->get_csrf_hash();?>";
				var table = $('#pdn_mytable').DataTable({ 
					"processing": true,
					"serverSide": true,
					"order": [],
					"ajax": {
						"url"  : "<?=base_url($pdn_url.'/data_json');?>",
						"type" : "POST",
						"data" : function ( d ) {
									d.<?=$this->security->get_csrf_token_name();?> = token;
								}
					},
					//optional
					"lengthMenu"	: [[10, 25, 50], [10, 25, 50]],
					"oLanguage"     : {
						"sProcessing":   "Sedang memproses...",
						"sLengthMenu":   "Tampilkan _MENU_ entri data",
						"sZeroRecords":  "Tidak ditemukan data yang sesuai",
						"sInfo":         "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri data",
						"sInfoEmpty":    "Menampilkan 0 sampai 0 dari 0 entri",
						"sInfoFiltered": "(disaring dari _MAX_ entri keseluruhan)",
						"sInfoPostFix":  "",
						"sSearch":       "Cari:",
						"sUrl":          "",
						"oPaginate": {
							"sFirst":    "Pertama",
							"sPrevious": "Sebelumnya",
							"sNext":     "Selanjutnya",
							"sLast":     "Terakhir"
						}
					},
					"columnDefs": [
						{
							"targets": [0,4],
							"sClass": "text-center",
							"orderable": false,
						},
					],
				});
				table.on('xhr.dt', function ( e, settings, json, xhr ) {
					token = json.<?=$this->security->get_csrf_token_name();?>;
				});
			});
		</script>