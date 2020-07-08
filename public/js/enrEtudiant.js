let generation1=document.getElementById("generation1");
generation1.style.display="none";
let generation3=document.getElementById("generation3");
generation3.style.display="none";
function choixBourse(sel) {
    let generation1=document.getElementById("generation1");
    let generation2=document.getElementById("generation2");
    let generation3=document.getElementById("generation3");
    if (sel.options[sel.selectedIndex].text=="Non") {
        generation1.style.display="none";
        generation2.style.display="block";
        generation3.style.display="none";
    }
    else {
        generation1.style.display="block";
    }
}

function choixLogement(sel) {
    let generation1=document.getElementById("generation1");
    let generation2=document.getElementById("generation2");
    let generation3=document.getElementById("generation3");
    if (sel.options[sel.selectedIndex].text=="Non") {
        generation2.style.display="block";
        generation3.style.display="none";
    }
    else {
        generation2.style.display="none";
        generation3.style.display="block";
    }
}
let formEnrEtudiant=document.getElementById("formEnrEtudiant");
formEnrEtudiant.addEventListener("submit",function (e) {
    if (verifPrenom()==false){
        e.preventDefault();
    }
    if (verifNom()==false){
        e.preventDefault();
    }
    if (verifEmail()==false){
        e.preventDefault();
    }
    if (verifTelephone()==false){
        e.preventDefault();
    }
    if (verifDateNaissance()==false){
        e.preventDefault();
    }
    if (verifAdresse()==false){
        //e.preventDefault();
    }
});
function verifPrenom() {
    let prenom=document.getElementById("prenom");
    if (prenom.value.length<2){
        prenom.style.borderColor="red";
        return false;
    }
    else{
        prenom.style.borderColor="green";
        return true;
    }
}
function verifNom() {
    let nom=document.getElementById("nom");
    if (nom.value.length<2){
        nom.style.borderColor="red";
        return false;
    }
    else{
        nom.style.borderColor="green";
        return true;
    }
}
function verifEmail() {
    let email=document.getElementById("email");
    if (email.value.length<2){
        email.style.borderColor="red";
        return false;
    }
    else{
        email.style.borderColor="green";
        return true;
    }
}
function verifTelephone() {
    let telephone=document.getElementById("telephone");
    if (telephone.value.length<2){
        telephone.style.borderColor="red";
        return false;
    }
    else{
        telephone.style.borderColor="green";
        return true;
    }
}
function verifDateNaissance() {
    let dateDeNaissanc=document.getElementById("dateDeNaissanc");
    if (dateDeNaissanc.value.length<2){
        dateDeNaissanc.style.borderColor="red";
        return false;
    }
    else{
        dateDeNaissanc.style.borderColor="green";
        return true;
    }
}
function verifAdresse() {
    let adresse=document.getElementById("adresse");
    if (adresse.value.length<2){
        adresse.style.borderColor="red";
        return false;
    }
    else{
        adresse.style.borderColor="green";
        return true;
    }
}