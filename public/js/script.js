function showRes(marque,modele,annee,immat,id_voiture){
    document.getElementById("res_form").style.display="block";
    document.getElementById("marque").innerHTML="Maruqe : "+marque;
    document.getElementById("modele").innerHTML="Modele : "+modele;
    document.getElementById("annee").innerHTML="Annee : "+annee;
    document.getElementById("immat").innerHTML="Immatriculation : "+immat;
    document.getElementById("id_voiture").value=id_voiture;
}
function closeResForm(){
    document.getElementById("res_form").style.display="none";
}