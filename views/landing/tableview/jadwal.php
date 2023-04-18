<script>
    widgetTable({
		id: 'table-x',
		query: `
			SELECT a.id menu, a.acara, a.tanggal, a.status  FROM jadwal a ORDER BY status ASC, id ASC {limit}
		`,
		limit: 10,
		remember: true,
		dataFilter: {
			rj: 'RJ'
			,search: ''
		},
		customeHead: function(element, data, ld){

		},
		pagination: true,
		conf: {
		    status:{
		      custome:function(a,b,c){
		          if(b.status == 0){
		              c.child(
		                el('span').html('<i class="fa fa-check"></i> dibuka')
		              )
		          }else{
		              c.child(
		                el('span').html('<i class="fa fa-times"></i> ditutup')
		              )
		          }
		          return '';
		      }
		    },
			menu:{
				custome: function(a, b, c) {
				    c.get().className = 'text-left';
				        c
    				    .child(
    				        btn().class('btn btn-primary btn-sm')
        				    .child(
        				        el('span').text('absensi ')
            				    .child(
            				        el('i').class('fa fa-users')
            				    )
        				    )
        				    .addModule('id', b.menu)
        				    .click(function(){
        				        location.href='<?= PATH ?>/dashboard/admin/jadwal/absensi/'+this.id;
        				    })
    				    )
					return '';
				}
			}
		},
		ifNone: function(a){
		    document.getElementById(a.id).innerHTML = `
		        <h1>Jadwal Acara</h1>
		        <p>buat jadwal baru dengan klik pada tombol dibawah </p>
		        <a href="/dashboard/admin/jadwal/tambah" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Acara</a>
		    `;
		}
	})
</script>
