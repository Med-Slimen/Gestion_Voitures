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
function showModifiy(marque,modele,annee,immat,id_voiture,disp){
    document.getElementById("modify_form").style.display="block";
    document.getElementById("marque_from").value=marque;
    document.getElementById("modele_from").value=modele;
    document.getElementById("annee_from").value=annee;
    document.getElementById("immat_from").value=immat;
    document.getElementById("old_disp").value=disp;
    document.getElementById("disp_form").selectedIndex=disp;
    document.getElementById("id_voiture").value=id_voiture;
}
function closeModifyForm(){
    document.getElementById("modify_form").style.display="none";
}
function showAdd(){
    document.getElementById("add_form").style.display="block";
}
function closeAddForm(){
    document.getElementById("add_form").style.display="none";
}
function verifDate() {
    let date_deb=new Date(document.getElementById("date_deb").value);
    let date_fin=new Date(document.getElementById("date_fin").value);
    let currenDate=new Date();
    //currenDate.setHours(0, 0, 0, 0);
    if(date_deb<currenDate || date_deb>date_fin){
        alert("Chose a valid date");
        return false;
    }
    return true;
}
function verifRes(){
    let old_disp=document.getElementById("old_disp").value;
    let new_dsip=document.getElementById("disp_form").value
    if(old_disp==0 && new_dsip==1){
        conf=confirm("La modification du disponibilité va supprimé la reservation automatiquent , Continuer ?")
        return conf;
    }
    return true;
}