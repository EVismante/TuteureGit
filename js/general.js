
window.onload = function() {


/* Les confirmations de suppression cote client et cote back office*/
$(".delete").on("click", function() {
  var msg = confirm("Voulez vous supprimer cet élèment?");
  if(msg) {
    return true;
  } else { return false;}
})

/**/
$("#del").on("click", function() {
  $("#hide").css("display", "block");
})

$("#annuler").on("click", function() {
  $("#hide").css("display", "none");
})

/*fenetre modal d'une diaporama*/
/*----------------------------------------------------*/
$("#diapo").on("click", function() {
 $("#diaporama").css("display", "block");
})

$("#fermer").on("click", function() {
 $("#diaporama").css("display", "none");
})

$(".arrow_right").on("click", function() {
 suivante("next");
})

$(".arrow_left").on("click", function() {
 suivante("prev");
})

  function suivante($sens) {
    var active = $("#diaporama .slideshowactive");
    var end = $('#diaporama img').last();
    var start = $('#diaporama img').first();
    var next;
    if($sens == "next") {
        if (active.is(end)) {
          next = start;
        } else {
          next = active.next();
        }
    } else {
      if (active.is(start)) {
          next = end;
        } else {
          next = active.prev();
        };
    }
    
    next.css('z-index', 2);
    active.fadeOut(0, function() {
    active.css('z-index', 1).show().removeClass("slideshowactive");
    next.css('z-index', 3).addClass("slideshowactive");

});

  }

  /*_-------------------- evaluation: les etoiles ----------------*/

  $("input[name='rating']").on("click", function() {
    var label = $(this).next().children();
  label.attr("src", "images/website/icons/pleine.svg");
  label.parent().prevAll().children().attr("src", "images/website/icons/pleine.svg");
  label.parent().nextAll().children().attr("src", "images/website/icons/vide.svg");
})


/*-------------------------------------------*/
/*animation de changement de H1 sur les pages des insertion de données*/
var initialvalue = $("#changejs").html(); //valeur initiale de H1
var lang = document.getElementsByTagName('html')[0].getAttribute('lang');
var name = document.getElementById("name_"+lang);

$(name).on("input", function() {

  var text = $(this).val();
  if (text.length > 0) {
    $("#changejs").html(text);
    $("#changeh4").css("opacity", "1");
  } else {
    $("#changejs").html(initialvalue);
    $("#changeh4").css("opacity", "0");
  }

})

/*-----------GESTION D'UPLOAD DES IMAGES---------------------*/
/*Préaffichage d'une image avant l'upload*/


$("[id^='file']").click(function(e) {
  var label = "label[for="+$(this).attr("id")+"]";
  var x = $(this).val(); //valeur d'input de file

    if (!x) { // si valeur est non definie, on ajoute une nouvelle image
      $(this).change(function() {
        voir_image(this, label);
});

    } else { // sinon on supprime l'image existante
      e.preventDefault();
      remove_image(this, label);
    }
});

$(".image_checkbox").click(function() { /*simulation visuelle de suppression d'une image*/
  var inputfile = $(this).prev();
  var label = "label[for="+$(inputfile).attr("id")+"]";

  $(this).css("display", "none");
  remove_image(inputfile, label);
})

function voir_image(elt, label) {
   
    var reader = new FileReader();

    reader.onload = function(e) {
      var img = e.target.result;
      $(label).addClass("on_delete");
      $(label).css("background-image", "url("+img+")");
      $(label+" span").removeClass("arrow_up");

    }
    reader.readAsDataURL(elt.files[0]);

}


function remove_image(elt, label) {
  $(elt).replaceWith($(elt).val('').clone(true));
   $(label).removeClass("on_delete");
   $(label).css("background-image", "none");
   $(label+" span").addClass("arrow_up");

}




/*-------------COMMENTAIRES-----------------------------------*/
/*pour l'affichage du champ de réponse aux commentaires*/
$("[id^=btn_repondre_]").on("click", function() {
   $(this).parent().next().slideToggle();
})

$("[id^=btn_edit_]").on("click", function() {
   $(this).next().slideToggle();
})


/*verifier si le commentaire n'est pas vide*/
$(".submit").click(function() {
  var form = $(this).parent();
  var textarea = form.find(".comment");
  var error_msg = form.find(".error_msg_comment");
  if (textarea.val().length < 1) { //verifie le longueur 
    textarea.addClass("error");
    $(error_msg).css("display", "block");
    return false;
  } else { 
    return true;
  }
})


/*------------------------------------------------------------*/
/*pour le message affiché après une action*/
$("#msg").click(function() {
  $(this).css("display", "none");
})

/* affichage des listes des resultats de la recherche */
$("#liste1").click(function() {
  $(this).css("background-color", "lightblue");
  $("#liste2").css("background-color", "#e2d4c0");
  $(".liste_clubs").css("display", "block");
  $(".liste_events").css("display", "none");
})

$("#liste2").click(function() {
  $(this).css("background-color", "lightblue");
  $("#liste1").css("background-color", "#e2d4c0");
  $(".liste_events").css("display", "block");
  $(".liste_clubs").css("display", "none");
})

/*Toogle le menu User on click -------------------*/
	$( "#user_icon" ).click(function() {
  		$(".user_menu").toggle();
});


    $(document).on("click", function(event){
        var $trigger = $(".nav");
        if($trigger !== event.target && !$trigger.has(event.target).length){
            $(".user_menu").hide();
        }            
    });
/*Toogle le menu on click -------------------*/
  $( "#mobile_menu" ).click(function() {
      $("#mobile_menu + div").toggle();
});

/*FORMULAIRES*/
/*----------------------------------------------------*/


$("#submit_contact").on("click", function() { 

  var bool1 = validate_length('input[id="name"]', 1);
  showMessage(bool1, "#msg_name");

  var bool2 = validate_mail('input[id="mail"]');
  showMessage(bool2, "#msg_mail");

  var bool3;
  
 var bool = $('#subject').val();
 if (bool.length > 5) { 
  bool3 = true;
 } else {bool3 = false;
  }
  showMessage(bool3, "#msg_subject");

    if (!bool1 || !bool2 || !bool3) { return false; } else {return true; }
});


$("#msg_success").on("click", function() { 
  $(this).css("display", "none");
});




$("#next").on("click", function() {
  $(".error_msg").css("display", "none");
  if($("input[name='name_fr']").parent().hasClass("active")) {
   var res = validate_length('input[name="name_fr"]', 2);
  }

  if($("input[name='name']").parent().hasClass("active")) {
   var res = validate_length('input[name="name"]', 2);
  }

  if($("input[name='name_en']").parent().hasClass("active")) {
   var res = validate_length('input[name="name_en"]', 2);
  }

   if($(".filtres").parent().hasClass("active")) {
   var res = true;
  }

    if($("input[name='MAX_FILE_SIZE']").parent().hasClass("active")) {
   var res = true;
  }

  if($("input[name='address']").parent().hasClass("active")) {
   var res = validate_length('input[name="address"]', 2);
  }

   if($("input[name='date']").parent().hasClass("active")) {
   var t1 = validate_length('input[name="date"]', 1);
   var t2 = validate_length('input[name="address"]', 2);

   if(t1 && t2) {res = true;} else { res = false;}
  }

  if(res) {
    formEtapes("next");
  } else { 
    $(".error_msg").css("display", "block"); }
})




$("#previous").on("click", function() {
 formEtapes("prev");
})

  function formEtapes($sens) {
    var active = $("#formulaire .active");
    var end = $('#formulaire .hide').last();
    var avant_end = end.prev('div');
    var start = $('#formulaire .hide').first();
    var next
    /*les boutons du formulaire*/
    if($sens == "next") {
        if (active.is(end)) {
          next = end;
          $("#previous").removeClass("inactive");
  
        } else if(active.is(avant_end)) {
          next = active.next();
          $("#next").css("display", "none");
          $("*[id^='submit']").css("display", "block");

        } else {

          next = active.next();
          $("#previous").removeClass("inactive");
          $("#next").removeClass("inactive");
        }
    } else {
      if (active.is(start)) {
          next = start;
          $("#previous").addClass("inactive");
          $("#next").removeClass("inactive");
        } else {
          next = active.prev();
          $("#previous").removeClass("inactive");
          $("#next").removeClass("inactive");
        };
    }
    /*la chaine des étapes du formulaire*/
    next.css('z-index', 2);
    active.fadeOut(0, function() {
    active.css('z-index', 1).show().removeClass("active");
    next.css('z-index', 3).addClass("active");

});

  }

/*montre "Plus d'info" sur la page d'inscription*/
$("#savoir").on("click", function() {
  $("#savoir1").toggle();
})

/*------------NEW CLUB vérification des donnees---------------------*/
  $("#submit_new_club").bind("click", function() {
  var t1 = validate_length('input[name="name"]', 1);
  var t2 = validate_length('input[name="address"]', 1);

  if(t1 && t2) {
    return true;
  } else { 
    $("#error_msg").css("display", "block");
    return false; }
});

    $("#submit_new_event").bind("click", function() {
  var t1 = validate_length('input[name="name_FR"]', 2);
  var t2 = validate_length('input[name="address"]', 2);
  var t3 = validate_length('input[name="date"]', 1);
  var t4 = validate_length('input[name="name_EN"]', 1);


  if(t1 && t2 && t3 && t4) {
    return true;
  } else { 
    $("#error_msg").css("display", "block");
    return false; }
});


  $("#submit_new_article").bind("click", function() {
  var t1 = validate_length('input[name="titre_FR"]', 1);
  var t2 = validate_length('input[name="article_FR"]', 1);

  if(t1 && t2) {
    return true;
  } else { 
    $("#error_msg").css("display", "block");
    return false; }
});


/*------------Forme d'inscription: validation des données---------------------*/

$("#submit_inscription").on("click", function() {

      var bool1 = validate_length("#username", 4);
      showMessage(bool1, "#msg_nom");

      var bool2 = validate_length("#mdp", 6);
      showMessage(bool2, "#msg_mdp");

      var bool3 = validate_match("#mdp", "#mdp1");
      showMessage(bool3, "#msg_mdp1");

      var bool4 = validate_mail("#mail");
      showMessage(bool4, "#msg_mail");

      var bool5 = validate_match("#mail", "#mail1");
      showMessage(bool5, "#msg_mail1");

      var bool6;

  $.ajax( //verifie si l'username existe déjà
    {   type: "POST",
        url: "pages/check_username.php",
        data: {name: $("#username").val()},
        async: false,
        success:

    function(data){ 

        if (data == '1') {
          bool6 = false;
          $("#username").addClass( "error" );
          $("#msg_nom1").css("display", "block");
        }

        if (data == '0') {
          $("#username").removeClass( "error" );
          $("#msg_nom1").css("display", "none");
          bool6 = true;
        } else {
          bool6= false;
        }
 }
  });


  if (bool1 && bool2 && bool3 && bool4 && bool5 && bool6) { return true; 
  } else { return false;}
})




/*-------verification de mot de passe -----*/
$("#submit_mdp").on("click", function() { //valider les nouveaux mdp

      var bool1 = validate_length("#mdp", 6);
      showMessage(bool1, "#msg_mdp");

      var bool2 = validate_match("#mdp", "#mdp1");
      showMessage(bool2, "#msg_mdp1");

  if (!bool1 || !bool2 ) { return false; }

});


/*-------verification du mail -----*/
$("#submit_mail").on("click", function() { //valider les mail

      var bool1 = validate_length("#mail", 6);
      showMessage(bool1, "#msg_mail");

      var bool2 = validate_match("#mail", "#mail1");
      showMessage(bool2, "#msg_mail1");

    if (!bool1 || !bool2 ) { return false; }
});

/*-------verification du login -----*/
$("#submit_login").on("click", function() { 

  var bool1 = validate_length("#name", 1);
  showMessage(bool1, ".msg2");

  var bool2 = validate_length("#mdp", 1);
   showMessage(bool2, ".msg3");

  if (!bool1 || !bool2 ) { return false; }
});


/*-------------------------------------------------*/
/*-------------------------------------------------*/

function showMessage(bool, message) {
    if ( bool ) {
      $(message).css("display", "none");
      var result = true;
  } else { 
    $(message).css("display", "block");
      var result = false;
  }
  return result;
}


/*voir si les deux champs sont identiques*/
function validate_match(elt1, elt2) {

  if($(elt1).val() !== $(elt2).val()) { 
      $(elt2).addClass( "error" );
      return false;
    } else {
      $(elt2).removeClass( "error" );
      return true;
    }
}



function validate_length(elt, length) {
  var value = document.querySelector(elt).value;
  if(value.length < length) { 
      $(elt).addClass( "error" );
      $(elt).on("input", function() {
      if(($(this).val().length > 1)) {
        $(this).removeClass("error" );} 
})
      return false;
    } else {
      return true;
    }
}

function validate_mail(mail) {
  var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/; 
    if($(mail).val().match(mailformat)) { 
      $(mail).removeClass( "error" );
      return true;
    } else {
      $(mail).addClass( "error" );
      return false;
};
}

/*-------------------------------------------------*/
/*-------------------------------------------------*/

/*verification des informations et champs */

$("#username").on("input", function() {
  var name = $(this).val();
  if(name.length > 2) {
    return false;
  } 
})


function checkname(name)
{

 if(name)
 {
  $.ajax({
  type: 'post',
  url: 'verify.php',
  data: {
   username:name,
  },
  success: function (response) {
   $( '#msg_nom' ).html(response);
   if(response=="OK") 
   {
    return true;  
   }
   else
   {
    return false; 
   }
  }
  });
 }
 else
 {
  $( '#name_status' ).html("");
  return false;
 }
}



/*------------CONTROLE DES FILTRES DE LA RECHERCHE---------------------*/

/*----------Bouton pour reduire le menu------------------*/
$("#make_smaller").click(function() {
    if($(this).hasClass("clicked")){
        $(this).removeClass("clicked");
        $(".result_paneau").animate({left: "-380px"}, { duration: 200, queue: false });
        $(this).animate({left: "10px"}, { duration: 200, queue: false });
        $("#make_smaller div").css("transform", "rotate(-90deg)");

    }else{
        $(this).addClass("clicked");
        $(".result_paneau").animate({left: "0px"}, { duration: 200, queue: false });
        $(this).animate({left: "385px"}, { duration: 200, queue: false });
        $("#make_smaller div").css("transform", "rotate(90deg)");
    }
});


/*----------filtres------------------*/

$("#filtres div").css("display", "none"); /*CACHE Les options*/

$("#filtres span").click(function() {
  $("+div", this).slideToggle();
})


}  /*ICI LA FIN DE ONLOAD JE SUPPOSE*/

/*----------filtrer les résultats de la recherche------------------*/

function search() {
  
  var input, filter, table, tr, td, i;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");

  // Boucle pour la recherche
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}

/*---------------------FAVORIS----------------------------*/


function addFavori(page_id, page_type, poof) { // poof supprime l'element sur la page des favoris.
    var eltId = $('#favori_'+page_type+page_id);
    var label = "label[for='favori_"+page_type+page_id+"'] .heart_icon";

  if (poof) { // il s'agit d'une page avec plusieurs favoris'
    var checked = false;
    eltId.parent().css("display", "none");

  } else { // il s'agit de la page d'un club avec un seul favori

    var checked = eltId.is(":checked");

    /*changement d'icone de favori*/
    if(checked) {
      $(label).attr("src", "images/website/icons/heart-pleine.svg");
    } else {
      $(label).attr("src", "images/website/icons/heart-vide.svg");
    }
  }

  $.get("pages/Favoris/add_favori.php", 
      { page_id: page_id, 
        page_type: page_type, 
        checked: checked
        });

}

/*----------Gestion des clubs et evenements------------------*/

  $( function() {
    $( "#datepicker" ).datepicker({
    altField: "#datepicker",
    closeText: 'Fermer',
    prevText: 'Précédent',
    nextText: 'Suivant',
    currentText: 'Aujourd\'hui',
    monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
    monthNamesShort: ['Janv.', 'Févr.', 'Mars', 'Avril', 'Mai', 'Juin', 'Juil.', 'Août', 'Sept.', 'Oct.', 'Nov.', 'Déc.'],
    dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
    dayNamesShort: ['Dim.', 'Lun.', 'Mar.', 'Mer.', 'Jeu.', 'Ven.', 'Sam.'],
    dayNamesMin: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
    weekHeader: 'Sem.',
    dateFormat: "yy-mm-dd"
});
  } );



