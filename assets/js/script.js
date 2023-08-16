$('#exampleModal2').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var id = button.data('id') // Extract info from data-* attributes
    var name = button.data('name') // Extract info from data-* attributes
    var number = button.data('number') // Extract info from data-* attributes
    var photo = button.data('photo') // Extract info from data-* attributes
    
    var modal = $(this)

    modal.find('.modal-body #id').val(id)
    modal.find('.modal-body #name').val(name)
    modal.find('.modal-body #number').val(number)
    modal.find('.modal-body #photo').val(photo)
  })