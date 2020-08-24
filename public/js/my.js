$(document).ready(function(){
    // Smazani klienta
    $('.remove-client').on('click', function(ev){
        ev.preventDefault();

        var form = $('#remove-client-form');
        var action = $(this).attr('data-remove-link');
        if(window.confirm('Opravdu smazat uživatele?')){
            form.attr('action',action);
            form.submit();
        }

    });
    
    // smazani přílohy ticketu
    $('.remove-attachment').on('click',function(){
        var action = $(this).attr('data-remove-link');
        var form = $('#remove-attachment-form');
        form.attr('action',action);
        form.submit();            
    });
    
    // smazání ticketu
    $('.remove-ticket').on('click',function(ev){
        ev.preventDefault();
        var action = $(this).attr('data-remove-link');        
        var form = $('#remove-ticket-form');
        if(window.confirm('Opravdu smazat ticket?')){
          form.attr('action',action);
          form.submit();
        }
    });
    // přidání polí pro nové kredity
    $('#add-credit').on('click',function(){
       addCredit($(this));
    });
    
    // odebrání polí pro kredity
    $(document).on('click','.remove-credit-inputs',function(e){
        e.preventDefault();
       $(this).closest('.addrow').remove();
    });

    // pridani radku tabulky s hodinami v editaci uzivatele
    $('.pridathodiny').on('click',function(){
        addCreditRow();
    });

    // odebrani
    $(document).on('click','.remove-credit-row',function(e){
        e.preventDefault();
        $(this).closest('tr').remove();
    });
    // zaktivneni radku pro editaci hodin klienta
    $(document).on('click','.update-credit-row',function(e){
        e.preventDefault();
        var td = $(this).closest('td');
        var tr = $(this).closest('tr');
        tr.find('input').prop('disabled',false);
        td.find('*').toggle();
    });

    // zdeaktivneni radku pro editaci hodin klienta
    $(document).on('click','.save-credit-row',function(e){
        e.preventDefault();

        var td = $(this).closest('td');
        var tr = $(this).closest('tr');

        tr.find('input').prop('disabled',true);
        td.find('*').toggle();
    });

    // zapnuti disabled inputu aby byly pristupne hodnoty po odeslani formu
    $('.enabled-disabled').on('click',function(e){
        var form = $(this).closest('form');
        form.find('[disabled]').prop('disabled',false);
    });
    
    //označení všech check-boxů na stránce
    $('.all-checkboxes').on('change',function(){
        $('input[type="checkbox"]').prop('checked',this.checked);
    });
    
    $('.show-comment-form').on('click',function(){        
        $('#comment-form-div').show();
        $(this).parent().hide();
    });

    $(document).on('click','.remove-ip-input',function(e){
        e.preventDefault();
        $(this).closest('.box').remove();
    });

    $('#add-ip-address').on('click',function(){
        addIpAddress($(this));
    });

    $('#generate-password').on('click',function(){
        var password = generatePassword();
        $('#pw').val(password);
        $('#pw2').val(password);
    });

    $('#copy-to-clipboard').on('click',function(){
       copyToClipboard();
    });

    $('#add-credit').click();
    
});

// zobrazeni nazvu priloh po vybrani
window.onload = function(){
    var upload = document.querySelector('#uploadfile');

    if(upload){
        upload.onchange = function(){
            var files = upload.files;
            var length = files.length;
            var edit = this.dataset.edit;
            if(edit != 1){
                document.getElementById('files').innerHTML = "";
            }
            for(var i=0; i < length; i++){
                addFileThumbnail(files[i].name,edit);
            }
        }
    }

};

// vytvoreni nahledu prilohy(nazev)
function addFileThumbnail(filename, edit){
    var div = $("<div class='priloha'>");
    var innerDiv = $("<div>");
    //var remove = $("<a  href='#' title='Odebrat' class='remove-attachment'><img src='img/smazat.png' alt='Odebrat'>");

    innerDiv.text(filename);
    div.append(innerDiv);
    //div.append(remove);
    var parent = edit != 1 ? $('#files') : $('#new-files')

    parent.append(div);
}

// vytvoreni inputboxu pro kredity
function addCredit(button){

    var html = $('<div class="filtration-content addrow flx">'+
        '<div class="box">' +
        '<label for="">Počet kreditů (hodin):</label>' +
        '<input type="text"  value="" name="count[]">' +
        '</div>' +
        '<div class="box">' +
        '<label for="">Platnost kreditů (Od):</label>' +
        '<input type="text" autocomplete="off" value="" class="datepicker" name="valid_from[]">' +
        '</div>' +
        '<div class="box">' +
        '<label for="">Platnost kreditů (Do):</label>' +
        '<input type="text" autocomplete="off" value="" class="datepicker" name="valid_to[]">' +
        '<a href="" class="remove-button remove-credit-inputs"><img src="../img/akcesmazat.svg" alt="Smazat"></a>'+
        '</div>' +
        '</div>');

   html.insertBefore(button);
   html.find('.datepicker').datepicker({ minDate: 0});
}

function addCreditRow(){
    var html = $(' <tr>\n' +
        '                                        <td><input type="text" name="count[]" id="" value="" ></td>\n' +
        '                                        <td><input type="text" autocomplete="off" value="0" name="removed_count[]" ></td>\n' +
        '                                        <td><input type="text" autocomplete="off" value="" name="valid_from[]" class="datepicker" ></td>\n' +
        '                                        <td><input type="text" autocomplete="off" name="valid_to[]" value="" class="datepicker" ></td>\n' +
        '                                        <td class="editovat">\n' +
        '                                            <a title="Upravit" class="update-credit-row" href="#"><img src="../../img/akceedit.svg" alt="Upravit"></a>\n' +
        '                                            <a title="Smazat" class="remove-credit-row" href="#" class="remove-credit-row"><img src="../../img/akcesmazat.svg" alt="Smazat"></a>\n' +
        '                                            <a class="button save-credit-row" style="display : none" href="#">uložit změny</a>\n' +
        '                                        </td>\n' +
        '                                    </tr>')
    html.find('.datepicker').datepicker({ minDate: 0, maxDate: "+2M +10D"});
    var update = html.find('.update-credit-row');
    var td = update.closest('td');

    var tbody = $('#credit-table-body');
    tbody.append(html);
    td.find('*').toggle();
}

function addIpAddress(button){
    var html = $('<div class="box block w-25">\n' +
        '<input type="text" name="allowedIp[]">\n' +
        '<a href="" class="remove-button remove-ip-input"><img src="../../img/akcesmazat.svg" alt="Smazat"></a>\n' +
        '</div>');
    html.insertBefore(button);
}

function generatePassword() {
    var length = 8,
        charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",
        retVal = "";
    for (var i = 0, n = charset.length; i < length; ++i) {
        retVal += charset.charAt(Math.floor(Math.random() * n));
    }
    return retVal;
}

function copyToClipboard() {
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val($('#pw').val()).select();
    document.execCommand("copy");
    $temp.remove();
}


