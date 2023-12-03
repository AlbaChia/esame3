  <?php
  require_once('utility/UTILITY.php');
  use Mieclassi\utility as UT;
  

  ?>

  

    <!-- FORM -->
    <?php
    $inviato =  UT::richiestaHTTP("inviato");
    $inviato = ($inviato == null || $inviato != 1) ? false : true;

    if ($inviato) {

      $valido = 0;
      // recupero dati
      $nome = UT::richiestaHTTP("nome");
      $cognome = UT::richiestaHTTP("cognome");
      $email = UT::richiestaHTTP("email");
      $telefono = UT::richiestaHTTP("telefono");
      $argomento = UT::richiestaHTTP("argomento");
      $oggetto = UT::richiestaHTTP("oggetto");
      $testo = UT::richiestaHTTP("testo");

      $clsErrore = ' class="errore" ';

      if (($nome != "") && UT::controllaRangeStringa($nome, 0, 50)) {
        $clsErrorenome = "";
      } else {
        $valido++;
        $clsErrorenome = $clsErrore;
        $nome = "";
      }

      if (($cognome != "") && UT::controllaRangeStringa($cognome, 0, 50)) {
        $clsErrorecognome = "";
      } else {
        $valido++;
        $clsErrorecognome = $clsErrore;
        $cognome = "";
      }

      if (($email != "") && UT::controllaRangeStringa($email, 10, 100)  && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $clsErroreemail = "";
      } else {
        $valido++;
        $clsErroreemail = $clsErrore;
        $email = "";
      }

      if (($telefono != "") && UT::controllaRangeStringa($telefono, 5, 15) && filter_var($telefono,  FILTER_SANITIZE_NUMBER_INT)) {
        $clsErroretelefono = "";
      } else {
        $valido++;
        $clsErroretelefono = $clsErrore;
        $telefono = "";
      }


      if (($oggetto != "") && UT::controllaRangeStringa($oggetto, 3, 20)) {
        $clsErroreoggetto = "";
      } else {
        $valido++;
        $clsErroreoggetto = $clsErrore;
        $oggetto = "";
      }
      if (($testo != "") && UT::controllaRangeStringa($testo, 0, 200)) {
        $clsErroretesto = "";
      } else {
        $valido++;
        $clsErroretesto = $clsErrore;
        $testo = "";
      }

      $inviato = ($valido == 0) ? true : false;
    } else {
      $nome = "";
      $cognome = "";
      $email = "";
      $telefono = "";
      $oggetto = "";
      $testo = "";

      $clsErrorenome = "";
      $clsErrorecognome = "";
      $clsErroreemail = "";
      $clsErroretelefono = "";

      $clsErroreoggetto = "";
      $clsErroretesto = "";
    }


    ?>

    <main>

      <?php
      if (!$inviato) {
      ?>
  <form action="#contatti.php?inviato=1" id="form" method="post" novalidate>
            <h1>RICHIEDI INFO!</h1>

            <label for="nome" id="lb_nome" <?php echo $clsErrorenome; ?>>Nome<span>*</span></label>
            <input type="text" id="nome" name="nome" required maxlength="50" value="<?php echo $nome; ?>">

            <label for="cognome" id="lb_cognome" <?php echo $clsErrorecognome; ?>>cognome<span>*</span></label>
            <input type="text" id="cognome" name="cognome" required maxlength="50" value="<?php echo $cognome; ?>">

            <label for="email" id="lb_email" <?php echo $clsErroreemail; ?>>email<span>*</span></label>
            <input type="text" id="email" name="email" required maxlength="100" value="<?php echo $email; ?>">

            <label for="telefono" id="lb_tel" <?php echo $clsErroretelefono; ?>>telefono<span>*</span></label>
            <input type="text" id="telefono" name="telefono" required maxlength="20" value="<?php echo $telefono; ?>">

            <label for="oggetto" id="lb_oggetto" <?php echo $clsErroreoggetto; ?>>oggetto<span>*</span></label>
            <input type="text" id="oggetto" name="oggetto" required maxlength="50" value="<?php echo $oggetto; ?>">

            <label for="testo" id="lb_testo" <?php echo $clsErroretesto; ?>>testo<span>*</span></label>
            <textarea name="testo" id="testo" cols="20" rows="10" required value="<?php echo $testo; ?>"></textarea>

            <button class="btn" id="conferma">INVIA!</button>
    </form>
              <?php
        //SCRITTURA DATI SU DB
      } else {
        $nome = $_POST['nome'];
        $cognome =  $_POST['cognome'];
        $email =  $_POST['email'];
        $telefono =  $_POST['telefono'];
        $oggetto =  $_POST['oggetto'];
        $testo =  $_POST['testo'];

        $sql = "INSERT INTO utente (nome, cognome, email, telefono, oggetto, testo) 
                      VALUES ('$nome', '$cognome', '$email', '$telefono',' $oggetto', '$testo')";
        $query = $mysqli->query($sql);

        if ($sql) {
          printf('<h2> Grazie per averci contattato! </h2>');
        } else {
          printf("<br>invio non avvenuto");
        }
      }
        ?>






<!-- VALIDAZIONE FORM LATO CLIENT - JS -->
<script type="application/javascript">
          let UT = new utility();


  window.onload = function() {
    const form = document.getElementById('form');
    const btn = document.getElementById('conferma');

    btn.onclick = function() {
      console.log('submit');
      let valido = 0;
      const nome = document.getElementById('nome').value;
      const lb_nome = document.getElementById('lb_nome');

      valido += nome != null && nome != "" && UT.controlloRangeStringa(nome, 0, 50) ? 0 : 1;
      console.log('VALIDO', valido);
      if (valido > 0) {
        lb_nome.classList.add('errore');

      } else {
        lb_nome.classList.remove('errore');
      }

      const cognome = document.getElementById('cognome').value;
      const lb_cognome = document.getElementById('lb_cognome');

      valido += cognome != null && cognome != "" && UT.controlloRangeStringa(cognome, 0, 25) ? 0 : 1;
      console.log('VALIDO', valido);
      if (valido > 0) {
        lb_cognome.classList.add('errore');

      } else {
        lb_cognome.classList.remove('errore');

      }

      const email = document.getElementById('email').value;
      const lb_email = document.getElementById('lb_email');

      valido += email != null && email != "" && UT.controlloRangeStringa(email, 10, 100) && UT.validaEmail(email) ? 0 : 1;
      console.log('VALIDO', valido);
      if (valido > 0) {
        lb_email.classList.add('errore');

      } else {
        lb_email.classList.remove('errore');

      }

      const tel = document.getElementById('tel').value;
      const lb_tel = document.getElementById('lb_tel');

      valido += tel != null && tel != "" && UT.controlloRangeStringa(tel, 0, 25) && UT.phoneNumber(tel) ? 0 : 1;
      console.log('VALIDO', valido);
      if (valido > 0) {
        lb_tel.classList.add('errore');

      } else {
        lb_tel.classList.remove('errore');

      }


      const oggetto = document.getElementById('oggetto').value;
      const lb_oggetto = document.getElementById('lb_oggetto');

      valido += oggetto != null && oggetto != "" && UT.controlloRangeStringa(oggetto, 0, 25) ? 0 : 1;
      console.log('VALIDO', valido);
      if (valido > 0) {
        lb_oggetto.classList.add('errore');

      } else {
        lb_oggetto.classList.remove('errore');

      }

      const testo = document.getElementById('testo').value;
      const lb_testo = document.getElementById('lb_testo');

      valido += testo != null && testo != "" && UT.controlloRangeStringa(testo, 0, 100) ? 0 : 1;
      console.log('VALIDO', valido);
      if (valido > 0) {
        lb_testo.classList.add('errore');

      } else {
        lb_testo.classList.remove('errore');

      }
    }
  }
</script>