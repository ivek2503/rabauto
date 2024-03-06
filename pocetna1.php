<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Stranica</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/11.0.2/css/bootstrap-slider.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/11.0.2/bootstrap-slider.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.2.min.js"></script>

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #0077cc;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .navbar {
            background-color: #f2f2f2;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: 100%;
        }

        .logo img {
            height: 90px;
        }

        .user-profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }

        .container {
            display: flex;
            justify-content: space-between;
            align-items: stretch;
            width: 100%;
            max-width: 800px;
            margin: 20px;
        }

        .box {
            background-color: #fff;
            border: 2px solid #000;
            border-radius: 10px;
            padding: 20px;
            margin: 10px;
            display: flex;
            flex-direction: column;
        }

        .btn-primary {
            margin-top: auto;
        }

        /* Dodano: postavljanje iste visine i širine za oba prozora */
        .container {
            display: flex;
        }

        .container .box {
            flex: 1;
            margin: 10px;
        }



        .dropdown {
            margin-bottom: 10px;
        }

        .slider {
            width: 80%;
            /* Prilagodite širinu slajdera prema potrebi */
            margin-top: 20px;
        }

        .slider .slider-track {
            height: 10px;
            /* Prilagodite visinu trake slajdera prema potrebi */
        }

        #cijenaMin,
        #cijenaMax,
        #kilometrazaMin,
        #kilometrazaMax {
            width: 90px;
            /* Prilagodite širinu tekstualnih okvira prema potrebi */
            margin: 5px;
        }

        .slider-input {
            width: 70px;
            padding: 5px;
            text-align: center;
            margin: 5px;
            border: 1px solid #ced4da;
            border-radius: 5px;
        }
    </style>
</head>

<body>

    <header class="navbar">
        <div class="logo">
            <img src="rabauto_logo.jpg" alt="Logo">
        </div>
        <div class="user-profile">
            <img src="user.jpg" alt="Korisnik">
        </div>
    </header>

    <div class="container">
        <div class="box">
            <!-- Lični prozor s dropdown menijima i gumbom -->
            <p><b>PRONAĐI ŽELJENI AUTO</b></p>
            <div class="dropdown">
                <label for="marka" class="form-label">MARKA:</label>
                <select id="marka" class="form-select" aria-label="marka" onchange="updateModelDropdown()">
                    <option selected>Odaberi opciju...</option>
                    <option value="sve_marke">Odaberi sve marke</option>
                    <option value="Audi">Audi</option>
                    <option value="BMW">BMW</option>
                    <option value="Mercedes">Mercedes</option>
                    <option value="Toyota">Toyota</option>
                    <option value="Ford">Ford</option>
                    <option value="Chevrolet">Chevrolet</option>
                    <option value="Volkswagen">Volkswagen</option>
                    <option value="Honda">Honda</option>
                    <option value="Hyundai">Hyundai</option>
                    <option value="Nissan">Nissan</option>
                    <option value="Mazda">Mazda</option>
                </select>
            </div>
            <div class="dropdown">
                <label for="model" class="form-label">MODEL:</label>
                <select id="model" class="form-select" aria-label="model">
                    <option selected>Odaberi opciju...</option>
                    <!-- Opcije će se dinamički ažurirati putem JavaScript-a -->
                </select>
            </div>
            <a href="#" data-bs-toggle="modal" data-bs-target="#advancedOptionsModal">
                <p>Dodatne opcije...</p>
            </a>
            <button type="button" class="btn btn-primary w-100">PRETRAŽI</button>
        </div>
        <div class="box">
            <!-- Drugi prozor s bijelom bojom i crnim zaobljenim rubovima -->
            <p><b>ŽELIŠ DODATI SVOJ AUTO NA OGLAS?</b></p><br>
            <p>Pritisni plavi gumb DODAJ i postavi atribute</p><br>
            <button type="button" class="btn btn-primary w-100" data-toggle="modal" data-target="#dodajOglasModal">DODAJ</button>
        </div>
    </div>
    <div class="modal fade" id="advancedOptionsModal" tabindex="-1" aria-labelledby="advancedOptionsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="advancedOptionsModalLabel">Dodatne opcije pretraživanja</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="cijena" class="form-label">CIJENA:</label>
                        <input id="cijena" type="text" data-slider-min="0" data-slider-max="2000000" data-slider-step="1000" data-slider-value="[0,2000000]" class="slider">
                        <br>
                        <input id="cijenaMin" type="text" value="0" class="slider-input" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                        <input id="cijenaMax" type="text" value="200000" class="slider-input" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                    </div>
                    <div class="mb-3">
                        <label for="godiste" class="form-label">GODIŠTE:</label>
                        <select id="godiste" class="form-select">
                            <!-- JavaScript će popuniti opcije -->
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="kilometraza" class="form-label">KILOMETRAŽA:</label>
                        <input id="kilometraza" type="text" data-slider-min="0" data-slider-max="1500000" data-slider-step="5000" data-slider-value="[0,1500000]" class="slider">
                        <br>
                        <input id="kilometrazaMin" type="text" value="0" class="slider-input" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                        <input id="kilometrazaMax" type="text" value="1500000" class="slider-input" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zatvori</button>    
                    <button type="button" class="btn btn-primary">Primijeni</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="dodajOglasModal" tabindex="-1" aria-labelledby="dodajOglasModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dodajOglasModalLabel">Dodaj oglas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Forma za unos podataka za oglas -->
                <form id="dodajOglasForm">
                    <div class="mb-3">
                        <label for="markaOglas" class="form-label">MARKA:</label>
                        <select id="markaOglas" class="form-select" aria-label="markaOglas">
                            <!-- Popunite opcije marki prema potrebi -->
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="modelOglas" class="form-label">MODEL:</label>
                        <select id="modelOglas" class="form-select" aria-label="modelOglas">
                            <!-- Popunite opcije modela prema potrebi -->
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="godisteOglas" class="form-label">GODIŠTE:</label>
                        <select id="godisteOglas" class="form-select" aria-label="godisteOglas">
                            <!-- Popunite opcije godišta prema potrebi -->
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="kilometrazaOglas" class="form-label">KILOMETRAŽA:</label>
                        <input id="kilometrazaOglas" type="text" class="form-control" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                    </div>
                    <div class="mb-3">
                        <label for="cijenaOglas" class="form-label">CIJENA:</label>
                        <input id="cijenaOglas" type="text" class="form-control" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                    </div>
                    <div class="mb-3">
                        <label for="slikeOglas" class="form-label">SLIKE:</label>
                        <input id="slikeOglas" type="file" class="form-control" multiple>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zatvori</button>
                <button type="button" class="btn btn-primary" onclick="spremiOglas()">Spremi</button>
            </div>
        </div>
    </div>
</div>
    <script src="https://code.jquery.com/jquery-3.6.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/11.0.2/bootstrap-slider.min.js"></script>

    <script>
        function updateModelDropdown() {
            var selectedMarka = document.getElementById("marka").value;
            var modelDropdown = document.getElementById("model");

            // Očisti postojeće opcije
            modelDropdown.innerHTML = '<option selected>Odaberi opciju...</option>';

            // Dodaj nove opcije ovisno o odabranoj marki
            var modeli = [];

            switch (selectedMarka) {
                case "sve_marke":
                    modeli = ["Odaberi sve modele"];
                    break;
                case "Audi":
                    modeli = ["A1", "A3", "A4", "A6", "Q3", "Q5", "Q7", "TT", "R8", "S5", "Svi modeli"];
                    break;
                case "BMW":
                    modeli = ["Serija 1", "Serija 3", "Serija 5", "X1", "X3", "X5", "Z4", "M3", "M5", "i8", "Svi modeli"];
                    break;
                case "Mercedes":
                    modeli = ["A-Class", "C-Class", "E-Class", "S-Class", "GLA", "GLC", "GLE", "GLS", "AMG GT", "SL", "Svi modeli"];
                    break;
                case "Toyota":
                    modeli = ["Corolla", "Camry", "Prius", "RAV4", "Highlander", "Tacoma", "Sienna", "4Runner", "Land Cruiser", "Supra", "Svi modeli"];
                    break;
                case "Ford":
                    modeli = ["Focus", "Fusion", "Escape", "Explorer", "F-150", "Mustang", "Edge", "Ranger", "Bronco", "Expedition", "Svi modeli"];
                    break;
                case "Chevrolet":
                    modeli = ["Malibu", "Equinox", "Traverse", "Camaro", "Silverado", "Tahoe", "Suburban", "Corvette", "Blazer", "Colorado", "Svi modeli"];
                    break;
                case "Volkswagen":
                    modeli = ["Golf", "Passat", "Jetta", "Tiguan", "Atlas", "Arteon", "ID.4", "Touareg", "Beetle", "Atlas Cross Sport", "Svi modeli"];
                    break;
                case "Honda":
                    modeli = ["Civic", "Accord", "CR-V", "Pilot", "Odyssey", "Fit", "HR-V", "Ridgeline", "Insight", "Passport", "Svi modeli"];
                    break;
                case "Hyundai":
                    modeli = ["Elantra", "Sonata", "Tucson", "Santa Fe", "Palisade", "Kona", "Veloster", "Venue", "Nexo", "Ioniq", "Svi modeli"];
                    break;
                case "Nissan":
                    modeli = ["Altima", "Maxima", "Sentra", "Rogue", "Murano", "Pathfinder", "Titan", "Armada", "370Z", "Leaf", "Svi modeli"];
                    break;
                case "Mazda":
                    modeli = ["Mazda3", "Mazda6", "CX-30", "CX-5", "CX-9", "MX-5 Miata", "MX-5 RF", "Mazda2", "Mazda5", "RX-8", "Svi modeli"];
                    break;
                    // Dodajte dodatne case-ove za ostale marke
            }

            // Dodaj nove opcije u dropdown modela
            for (var i = 0; i < modeli.length; i++) {
                var option = document.createElement("option");
                option.value = modeli[i];
                option.text = modeli[i];
                modelDropdown.appendChild(option);
            }
        }

        function populateGodisteDropdown() {
            var godisteDropdown = document.getElementById("godiste");

            // Dodaj opcije od 2024 do 1970 unazad
            for (var godina = 2024; godina >= 1970; godina--) {
                var option = document.createElement("option");
                option.value = godina;
                option.text = godina;
                godisteDropdown.appendChild(option);
            }
        }
        var cijenaSlider = $("#cijena").slider();
        var kilometrazaSlider = $("#kilometraza").slider();

        // Pohrana prethodnih ispravnih vrijednosti za cijenu
        var previousCijenaMin = 0;
        var previousCijenaMax = 0;

        // Omogući povezivanje tekstualnih okvira s vrijednostima slajdera za cijenu
        cijenaSlider.on("slide", function(slideEvt) {
            $("#cijenaMin").val(slideEvt.value[0]);
            $("#cijenaMax").val(slideEvt.value[1]);

            // Pohrani trenutne vrijednosti
            previousCijenaMin = slideEvt.value[0];
            previousCijenaMax = slideEvt.value[1];
        });

        // Omogući povezivanje vrijednosti tekstualnih okvira s slajderom za cijenu
        $("#cijenaMin, #cijenaMax").on("input", function() {
            var minValue = parseInt($("#cijenaMin").val(), 10) || 0;
            var maxValue = parseInt($("#cijenaMax").val(), 10) || 0;

            // Provjeri da li je min cijena manja od max cijene
            if (minValue > maxValue) {
                alert("Min cijena ne može biti veća od max cijene.");

                // Vrati prethodno ispravne vrijednosti
                $("#cijenaMin").val(previousCijenaMin);
                $("#cijenaMax").val(previousCijenaMax);

                return;
            }

            // Pohrani trenutne vrijednosti
            previousCijenaMin = minValue;
            previousCijenaMax = maxValue;

            cijenaSlider.slider('setValue', [minValue, maxValue]);
        });

        // Pohrana prethodnih ispravnih vrijednosti za kilometražu
        var previousKilometrazaMin = 0;
        var previousKilometrazaMax = 0;

        // Omogući povezivanje tekstualnih okvira s vrijednostima slajdera za kilometražu
        kilometrazaSlider.on("slide", function(slideEvt) {
            $("#kilometrazaMin").val(slideEvt.value[0]);
            $("#kilometrazaMax").val(slideEvt.value[1]);

            // Pohrani trenutne vrijednosti
            previousKilometrazaMin = slideEvt.value[0];
            previousKilometrazaMax = slideEvt.value[1];
        });

        // Omogući povezivanje vrijednosti tekstualnih okvira s slajderom za kilometražu
        $("#kilometrazaMin, #kilometrazaMax").on("input", function() {
            var minKilometraza = parseInt($("#kilometrazaMin").val(), 10) || 0;
            var maxKilometraza = parseInt($("#kilometrazaMax").val(), 10) || 0;

            // Provjeri da li je min kilometraža manja od max kilometraže
            if (minKilometraza > maxKilometraza) {
                alert("Min kilometraža ne može biti veća od max kilometraže.");

                // Vrati prethodno ispravne vrijednosti
                $("#kilometrazaMin").val(previousKilometrazaMin);
                $("#kilometrazaMax").val(previousKilometrazaMax);

                return;
            }

            // Pohrani trenutne vrijednosti
            previousKilometrazaMin = minKilometraza;
            previousKilometrazaMax = maxKilometraza;

            kilometrazaSlider.slider('setValue', [minKilometraza, maxKilometraza]);
        });

        // Inicijalizacija slajdera za kilometražu
        kilometrazaSlider.slider();
        // Pozovi funkciju za popunjavanje dropdown-a za godište
        populateGodisteDropdown();
        function spremiOglas() {
        // Ovdje dodajte logiku za spremanje oglasa, uključujući slike
        // Primjer: Dobavljanje unesenih vrijednosti iz forme
        var marka = document.getElementById("markaOglas").value;
        var model = document.getElementById("modelOglas").value;
        var godiste = document.getElementById("godisteOglas").value;
        var kilometraza = document.getElementById("kilometrazaOglas").value;
        var cijena = document.getElementById("cijenaOglas").value;
        var slike = document.getElementById("slikeOglas").files;

        // Ovdje dodajte logiku za spremanje oglasa, uključujući slike
        // Primjer: Validacija i slanje podataka putem AJAX-a
        // ...

        // Zatvorite modalni prozor nakon spremanja oglasa
        $('#dodajOglasModal').modal('hide');
    }
    </script>
</body>

</html>