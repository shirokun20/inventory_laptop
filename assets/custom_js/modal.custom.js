var modalData = (judul = '',content = '', footer = '') => {
  var output = '<div class="modal" id="modalID">';
        output += '<div class="modal-dialog">';
          output += '<div class="modal-content">';
            output += '<div class="modal-header">';
              output += `<h4 class="modal-title">${judul}</h4>`;
              output += '<button type="button" class="close" data-dismiss="modal">&times;</button>';
            output += '</div>';
            output += '<div class="modal-body">';
            output += ` ${content}`;
            output += '</div>';
            if (footer.toString().length > 0) {
              output += '<div class="modal-footer">';
              output += `${footer}`;
              output += '</div>';
            }
          output += '</div>';
        output += '</div>';
      output += '</div>';
  return (output);
}