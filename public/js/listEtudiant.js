$(document).ready(function(){
    let offset = 0;
    let limit=7;
    $.ajax({
        type: "POST",
        url: "http://127.0.0.1:8000/etudiant/dataEtudiant",
        dataType: "json",
        data: {limit:limit,offset:offset},
        success: function (data) {
            scrollZone.html('')
            printData(data,scrollZone);
            offset +=limit;
        },
        error: function (data) {
            alert('Données non chargées')        }
    });

    //  Scroll
    const scrollZone = $('#ScrollZone')
    //  Zone
    const Zone = $('#Zone')
    Zone.scroll(function(){
        //console.log(scrollZone[0].clientHeight)
        const st = Zone[0].scrollTop;
        const sh = Zone[0].scrollHeight;
        const ch = Zone[0].clientHeight;
        if(sh-st <= ch){
            $.ajax({
                type: "POST",
                url: "http://127.0.0.1:8000/etudiant/dataEtudiant",
                data: {limit:limit,offset:offset},
                dataType: "JSON",
                success: function (data) {

                    console.log(ch)
                    printData(data,scrollZone);
                    offset +=limit;
                }
            });
        }

    })

    $('#search').click(function () {
        let req= $('#req').val();
        $.ajax({
            type: "POST",
            url: "http://127.0.0.1:8000/etudiant/searchEtudiant",
            dataType: "json",
            data: {req:req},
            success: function (data) {
                scrollZone.html('')
                printData(data,scrollZone);
            },
            error: function (data) {
                alert('Données non chargées')        }
        });
    })
});

function printData(data,scrollZone){
    $.each(data, function(indice,ligne)
    {
        let home;
        let champ;
        let sship;
        if(ligne.bourse=='Non')
        {
            sship='<option value"Non">Non</option><option value"Demi">Demi</option><option value"Entiere">Entiere</option>'
        }
        else if(ligne.bourse=='Demi'){
            sship='<option value"Demi">Demi</option><option value"Non">Non</option><option value"Entiere">Entiere</option>'
        }
        else{
            sship='<option value"Entiere">Entiere</option><option value"Demi">Demi</option><option value"Non">Non</option>'
        }
        if(ligne.adresse==null){
            home=ligne.numChambre;
            champ='<div class=""><label class="small">Num Chambre</label><input type="number" class="form-control" name="chambre" value="'+home+'"/></div>';
        }else{
            home=ligne.adresse;
            champ='<div class=""><label class="small">Addresse</label><input class="form-control" name="adresse"   value="'+ligne.adresse+'"/></div>';
        }
        scrollZone.append('<tr><td>'+ligne.matricule+'</td><td>'+ligne.prenom+'</td>' +
            '<td>'+ligne.nom+'</td><td>'+ligne.telephone+'</td><td>'+ligne.email+'<td>'+ligne.bourse+'</td><td>'+home+'<td>' +
            '<img src="/img/edit.png" alt="edit" class="mr-3 modsup" data-toggle="modal" data-target="#'+ligne.id+'">' +
            '<img src="/img/delete.png" alt="delete" class="modsup" data-toggle="modal" data-target="#delete'+ligne.id+'">' +
            '<div class="modal fade my-auto" id="delete'+ligne.id+'" role="dialog"><div class="modal-dialog">' +
            '<div class="modal-content"><div class="modal-header mt-2"><h4 class="modal-title">Supprimer l\'etudiant.</h4>' +
            '<button type="button" class="close" data-dismiss="modal">&times;</button></div>' +
            '<div class="modal-body"><h4 class="text-danger text-center">Voulez vous supprimer '+ligne.prenom+' '+ligne.nom+'?</h4></div>' +
            '<div class="modal-footer d-block"><form method="post" enctype="multipart/form-data">' +
            '<button name="delete" type="submit" class="btn btn-danger float-left" value="'+ligne.id+'">OUI</button>' +
            '<button type="button" class="btn btn-default float-right" data-dismiss="modal">NON</button></form>' +
            '</div></div></div></div><div class="modal fade mt-2" id="'+ligne.id+'" role="dialog">' +
            '<form method="post" enctype="multipart/form-data"><div class="modal-dialog"><div class="modal-content">' +
            '<div class="modal-header"><h4 class="modal-title">Modifier Etudiant</h4>' +
            '<button type="button" class="close" data-dismiss="modal">&times;</button></div><div class="modal-body">' +
            '<div class="form-group"><div class=""><label class="small">Prenom</label>' +
            '<input class="form-control"  name="prenom" value="'+ligne.prenom+'" type="text"/></div><div class="">' +
            '<label class="small">Nom</label><input class="form-control"  name="nom" value="'+ligne.nom+'" type="text"/>' +
            '</div><div class=""><label class="small">Telephone</label><input class="form-control"  name="telephone" value="'+ligne.telephone+'" type="text"/></div>' +
            '<div class=""><label class="small">Email</label><input class="form-control"  name="email" value="'+ligne.email+'" type="text"/></div>'+
            '<div class=""><label class="small">Bourse</label><select class="form-control" name="bourse" value="'+ligne.bourse+'">'+sship+'</select></div>'+champ+
            '</div><div class="modal-footer"><button name="submit" type="submit" class="btn btn-primary mr-4 mx-auto" value="'+ligne.id+'">Enregistrer</button>' +
            '<button type="button" class="btn btn-default ml-4" data-dismiss="modal">Close</button></div></div></div></form></div></td></tr>'
        );
    });
}
