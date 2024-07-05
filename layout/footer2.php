<!-- Optional JavaScript; choose one of the two! -->

<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
crossorigin="anonymous"></script>

<!-- asset plugin datatables -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>

<script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js"
 integrity="sha384-rOA1PnstxnOBLzCLMcre8ybwbTmemjzdNlILg8O7z1lUkLXozs4DHonlDtnE7fpc" 
 crossorigin="anonymous"></script>

 <!-- load ckeditor cdn -->
 <script src="https://cdn.ckeditor.com/4.24.0-lts/full/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('alamat'{
            filebrowserBrowserUrl: 'asset/ckfinder/ckinder.html',
            filebrowserUploadUrl: 'assets/ckifnder/core/connector/php/connector.php? command=QuickUpload&type=Files', 
            height  : '400px' 
        });
    </script>

<script>
$(document).ready(function() {
    $('#table').DataTable();
});
</script>

</body>
</html>
