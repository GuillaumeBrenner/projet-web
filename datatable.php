<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js">
</script>
<script type="text/javascript"
      src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/js/bootstrap.bundle.min.js">
</script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.11.5/datatables.min.js">
</script>
<script>
$(document).ready(function() {
      $('#dataList').DataTable({
            "language": {
                  "decimal": "",
                  "emptyTable": "Aucune donnée",
                  "info": " _START_  - _END_ / _TOTAL_ données",
                  "infoEmpty": "Showing 0 to 0 of 0 entries",
                  "infoFiltered": "",
                  "infoPostFix": "",
                  "thousands": ",",
                  "lengthMenu": "Montrer _MENU_ champs",
                  "loadingRecords": "Loading...",
                  "processing": "",
                  "search": "Rechercher",
                  "zeroRecords": "Aucune donnée ne correspond a votre recherche",
                  "paginate": {
                        "first": "Premier",
                        "last": "Dernier",
                        "next": "Suivant",
                        "previous": "Précédent"
                  },
                  "aria": {
                        "sortAscending": ": activate to sort column ascending",
                        "sortDescending": ": activate to sort column descending"
                  }
                  // LIEN POUR METTRE LE DATATABLE EN FRANCAIS SANS PERSONNALISER
                  // "url": "https://cdn.datatables.net/plug-ins/1.10.24/i18n/French.json"
            }

      });
});
</script>