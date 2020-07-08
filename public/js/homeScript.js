loading('listEtudiant');
loading('enrEtudiant');
loading('enrChambre');
loading('listChambre');

function loading(lien) {
    $(document).ready(function(){
        $("#"+lien).click(function(){
            $("#html").load("localhost/G2_POO_AD1_PISD2/user/"+lien);
            $("li").removeClass("active")
            $("#"+lien).addClass("active");
        });
    });    
}
