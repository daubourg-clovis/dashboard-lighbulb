// function deletecheck (){
//     const confirm = document.getElementsByClassName('deletecheck');
//     array.forEach(confirm => {
        
//     });
    
// }

deleteId = 0;
$('#staticBackdrop').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    deleteId = button[0].dataset.id;
    });

$('#btn-delete').click(function(){
    $(location).attr('href', 'delete.php?id='+deleteId);
});