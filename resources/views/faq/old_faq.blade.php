@extends('layouts.suplay')
@section('content')
    <!-- FAQ bar -->
<div id="wrapper">
    @include('faq.sidebar.sidebar')
    <!-- /#sidebar-wrapper -->

    <div id="faq-container">
        <h1>{{app()->make('play_faq_url')}}</h1>

        <div class="container-fluid px-0 lie-fullwidth">
            <div class="container pb-5 pb-lg-0 mb-3">
                <div class="row no-gutters">
                    <div class="col-12 col-lg-8 pl-lg-0 pt-5 pb-4 pr-0 pr-lg-5 d-flex align-items-start flex-column js-find-link-and-create-click-area has-link">
                        <span class="su-theme-anchor mb-4"></span>
                        <h2>Manual and guides</h2>
                        <p class="lead-light txt-blok-3">{{__("Here we have collected instructions on some of the most important functions.")}}</p>
                    </div>

                </div>
            </div>
        </div>


        <article class="main-article webb2021-article main-column-left js-anchor-links-headers-container col-12 col-lg-8 main-column-padding-right">
            <p class="lead-light">{{__("Here we have collected instructions on some of the most important functions.")}}</p>

            <h2 id="wiplay">What is DSVPlay?</h2>
            @include('faq.wiplay')

            <h2 id="lang">Language</h2>
            @include('faq.language')

            <h2 id="rap">Roles and permissions</h2>
            @include('faq.rap')


            <p>Dina rättigheter som student regleras dels i lagar och förordningar, dels i lokala föreskrifter vid Stockholms universitet.</p>

            <span class="su-anchor" id="universitetetsstyrdokumentriktlinjerochkursplaner">&nbsp;</span><h2>Universitetets styrdokument, riktlinjer och kursplaner</h2>

            <p>Styrdokument - regelboken, är en sammanställning av beslut som fattats av de centrala organen vid Stockholms universitet; universitetsstyrelsen, rektor och förvaltningschefen. I den kan du hitta mycket av den information universitetet har en skyldighet att tillhandahålla. Styrdokumenten är grupperade på ämnesområde, till exempel&nbsp;"Utbildning".</p>

            <p><a class="ck-special-link" href="https://www.su.se/medarbetare/organisation-styrning/styrdokument-regelboken">Styrdokument - regelboken</a></p>

            <p>Andra viktiga dokument att känna till är dina kurs- och utbildningsplaner. Dessa innehåller föreskrifter som ska tillämpas på en kurs eller inom ett program. De får inte frångås utan ska tillämpas förutsägbart och effektivt.</p>
            <hr aria-hidden="true"><span class="su-anchor" id="påverkadinutbildning">&nbsp;</span><h2>Påverka din utbildning</h2><p>Som student finns det en rad olika saker du kan göra för att vara med och påverka din utbildning. Läs mer via länken nedan.</p>

            <p><a class="ck-arrow-link" href="/utbildning/studera-vid-universitetet/dina-r%C3%A4ttigheter-och-skyldigheter/p%C3%A5verka-din-utbildning-1.479513">Så här kan du påverka din utbildning</a></p>

            <div class="image-block webb2021-image-default">
                <div class="image-block-image"><img alt="Studenter i ett grupprum på Biblioteket." class="article-image" src="/polopoly_fs/1.573095!/image/image.jpg_gen/derivatives/landscape_690/image.jpg">
                    <div class="image-block-description" id="caption">Foto: Niklas Björling</div>
                </div>
            </div>

            <div class="ck-collapsible-section no-gutters collapsible-item" id="Collapsiblearbetsochstudiemiljö">
                <div class="d-flex justify-content-between">
                    <div class="collapsible-item-heading" id="headingCollapsiblearbetsochstudiemiljö">
                        <span class="su-anchor" id="arbetsochstudiemiljö">&nbsp;</span>
                        <h2 class="collapsible-item-title collapsible-item-title-link">Arbets- och studiemiljö</h2>
                    </div>
                    <div class="text-right">
                        <button aria-controls="ccbd-arbetsochstudiemiljö" aria-expanded="false" aria-pressed="false" class="collapsed collapsible-item-title-link-icon button-remove-style link-styled su-js-toggle-btn" data-toggle="collapse" type="button" aria-label="Visa mer">
                            <span class="not-pressed">&nbsp;</span>
                            <span class="pressed">&nbsp;</span>
                        </button>
                    </div>
                </div>
                <div aria-labelledby="headingCollapsiblearbetsochstudiemiljö" class="collapse collapsible-item-collapse col-12" id="ccbd-arbetsochstudiemiljö">
                    <div class="pt-2">
                        <div class="collapsible-item-body">
                            <p>Arbets- och studiemiljön på universitetet är en viktig fråga för alla som vistas här – inte minst för dig som student. Allt från studieutrymmen till undervisningsform och oskrivna regler påverkar dig.</p>

                            <p><a class="ck-arrow-link" href="/utbildning/din-h%C3%A4lsa/arbets-och-studiemilj%C3%B6-vid-stockholms-universitet">Här kan du läsa om studenternas studiemiljöombud och universitetets arbetsmiljöarbete</a></p>
                        </div> </div> </div> </div><div class="ck-collapsible-section no-gutters collapsible-item" id="Collapsibleavbrytastudierochstudieuppehåll"><div class="d-flex justify-content-between"> <div class="collapsible-item-heading" id="headingCollapsibleavbrytastudierochstudieuppehåll"><span class="su-anchor" id="avbrytastudierochstudieuppehåll">&nbsp;</span><h2 class="collapsible-item-title collapsible-item-title-link">Avbryta studier och studieuppehåll</h2> </div><div class="text-right"><button aria-controls="ccbd-avbrytastudierochstudieuppehåll" aria-expanded="false" aria-pressed="false" class="collapsed collapsible-item-title-link-icon button-remove-style link-styled su-js-toggle-btn" data-toggle="collapse" type="button" aria-label="Visa mer"><span class="not-pressed">&nbsp;</span> <span class="pressed">&nbsp;</span></button></div> </div><div aria-labelledby="headingCollapsibleavbrytastudierochstudieuppehåll" class="collapse collapsible-item-collapse col-12" id="ccbd-avbrytastudierochstudieuppehåll"><div class="pt-2"> <div class="collapsible-item-body"><p>Ibland kan en student vilja avbryta sina studier eller göra studieuppehåll. Om det blir aktuellt för dig är det viktigt att du tar reda på vad som gäller.</p>

                            <p><a class="ck-special-link" href="/utbildning/studera-vid-universitetet/dina-r%C3%A4ttigheter-och-skyldigheter/avbryta-studier-och-studieuppeh%C3%A5ll-1.445631">Det här gäller om du vill avbryta studier eller ta studieuppehåll</a></p>
                        </div> </div> </div> </div><div class="ck-collapsible-section no-gutters collapsible-item" id="Collapsiblebreddadrekrytering"><div class="d-flex justify-content-between"> <div class="collapsible-item-heading" id="headingCollapsiblebreddadrekrytering"><span class="su-anchor" id="breddadrekrytering">&nbsp;</span><h2 class="collapsible-item-title collapsible-item-title-link">Breddad rekrytering</h2> </div><div class="text-right"><button aria-controls="ccbd-breddadrekrytering" aria-expanded="false" aria-pressed="false" class="collapsed collapsible-item-title-link-icon button-remove-style link-styled su-js-toggle-btn" data-toggle="collapse" type="button" aria-label="Visa mer"><span class="not-pressed">&nbsp;</span> <span class="pressed">&nbsp;</span></button></div> </div><div aria-labelledby="headingCollapsiblebreddadrekrytering" class="collapse collapsible-item-collapse col-12" id="ccbd-breddadrekrytering"><div class="pt-2"> <div class="collapsible-item-body"><p>Breddad rekrytering&nbsp;till högskolan är en rättvise- och demokratifråga.&nbsp;Det handlar om att göra universitetet mer tillgängligt, motverka social snedrekrytering och verka för att alla grupper i samhället får lika stor tillgång till högre utbildning.</p>

                            <p><a class="ck-special-link" href="/utbildning/studera-vid-universitetet/dina-r%C3%A4ttigheter-och-skyldigheter/breddad-rekrytering-och-breddat-deltagande-1.445692">Här kan du läsa mer om hur SU jobbar med breddad rekrytering och breddat deltagande</a></p>
                        </div> </div> </div> </div><div class="ck-collapsible-section no-gutters collapsible-item" id="Collapsiblefuskochplagiat"><div class="d-flex justify-content-between"> <div class="collapsible-item-heading" id="headingCollapsiblefuskochplagiat"><span class="su-anchor" id="fuskochplagiat">&nbsp;</span><h2 class="collapsible-item-title collapsible-item-title-link">Fusk och plagiat</h2> </div><div class="text-right"><button aria-controls="ccbd-fuskochplagiat" aria-expanded="false" aria-pressed="false" class="collapsed collapsible-item-title-link-icon button-remove-style link-styled su-js-toggle-btn" data-toggle="collapse" type="button" aria-label="Visa mer"><span class="not-pressed">&nbsp;</span> <span class="pressed">&nbsp;</span></button></div> </div><div aria-labelledby="headingCollapsiblefuskochplagiat" class="collapse collapsible-item-collapse col-12" id="ccbd-fuskochplagiat"><div class="pt-2"> <div class="collapsible-item-body"><p>Stockholms universitet ser mycket allvarligt på fusk. Med fusk menas exempelvis att studenter samarbetar på ett otillåtet sätt, medför otillåtna hjälpmedel (som till exempel fusklappar, otillåtna anteckningar eller mobiltelefon) eller på annat sätt försöker vilseleda vid examination. Plagiat utgör också en form av fusk och innebär till exempel att en student använder egna (självplagiat) eller andras texter och idéer utan att hänvisa till originalkällan på ett korrekt sätt i till exempel en uppsats, hemtentamen eller annan examinationsuppgift.&nbsp;</p>

                            <p>Misstanke om fusk utreds först av institutionen. Om institutionen bedömer att det finns en grundad misstanke om fusk anmäler institutionen ärendet vidare till rektor, som i sin tur kan överlämna ärendet till universitetets Disciplinnämnd. Fusk kan leda till att studenter varnas eller stängs av från studierna i upp till sex månader. En avstängning registreras som ett tillfälligt avbrott i studierna och kan påverka bl. a. studiemedel men även rätten till studentbostad. Ett beslut om avstängning gäller i regel omedelbart.</p>

                            <p>Var uppmärksam på de instruktioner du som student får angående examinationer och vilka regler som gäller. Även om du har genomfört examinationsmomentet under en tidigare termin kan förutsättningarna ha ändrats t. ex. vad gäller tillåtna hjälpmedel eller samarbeten. Ansvaret för att ta till sig och följa de instruktioner som ges ligger på studenten.</p>

                            <p>Studenter som blir anklagade eller misstänkta för vilseledande vid examination kan kontakta Stockholms universitets studentkår (SUS) för råd och stöd redan när misstanke om fusk riktas mot studenten. Studenter som studerar vid Institutionen för Data- och Systemvetenskap (DSV), kan istället kontakta Studentkåren DISK.</p>

                            <p>Är du som student osäker på vad som gäller för en examination? Hör av dig till kursansvarig lärare. Här kan du läsa mer om&nbsp;<a href="https://www.su.se/medarbetare/organisation-styrning/styrdokument-regelboken/utbildning/regler-och-handl%C3%A4ggningsordning-f%C3%B6r-disciplin%C3%A4renden-1.605869">Regler och handläggningsordning för disciplinärenden</a>&nbsp;vid Stockholms universitet.</p>
                        </div> </div> </div> </div><div class="ck-collapsible-section no-gutters collapsible-item" id="Collapsiblelikavillkor"><div class="d-flex justify-content-between"> <div class="collapsible-item-heading" id="headingCollapsiblelikavillkor"><span class="su-anchor" id="likavillkor">&nbsp;</span><h2 class="collapsible-item-title collapsible-item-title-link">Lika villkor</h2> </div><div class="text-right"><button aria-controls="ccbd-likavillkor" aria-expanded="false" aria-pressed="false" class="collapsed collapsible-item-title-link-icon button-remove-style link-styled su-js-toggle-btn" data-toggle="collapse" type="button" aria-label="Visa mer"><span class="not-pressed">&nbsp;</span> <span class="pressed">&nbsp;</span></button></div> </div><div aria-labelledby="headingCollapsiblelikavillkor" class="collapse collapsible-item-collapse col-12" id="ccbd-likavillkor"><div class="pt-2"> <div class="collapsible-item-body"><p>En bra arbets- och studiemiljö ska vara en självklarhet på Stockholms universitet. Alla studenter och anställda ska bemötas likvärdigt och på ett respektfullt sätt. Vi arbetar också för att motverka diskriminering och främja lika rättigheter och möjligheter vid verksamheten.</p>

                            <p><a class="ck-arrow-link" href="/utbildning/studera-vid-universitetet/dina-r%C3%A4ttigheter-och-skyldigheter/lika-villkor-1.445658">Här kan du läsa mer om lika villkor&nbsp;vid Stockholms universitet</a></p>
                        </div> </div> </div> </div><div class="ck-collapsible-section no-gutters collapsible-item" id="Collapsiblemiljöklimatochhållbarhet"><div class="d-flex justify-content-between"> <div class="collapsible-item-heading" id="headingCollapsiblemiljöklimatochhållbarhet"><span class="su-anchor" id="miljöklimatochhållbarhet">&nbsp;</span><h2 class="collapsible-item-title collapsible-item-title-link">Miljö, klimat och hållbarhet</h2> </div><div class="text-right"><button aria-controls="ccbd-miljöklimatochhållbarhet" aria-expanded="false" aria-pressed="false" class="collapsed collapsible-item-title-link-icon button-remove-style link-styled su-js-toggle-btn" data-toggle="collapse" type="button" aria-label="Visa mer"><span class="not-pressed">&nbsp;</span> <span class="pressed">&nbsp;</span></button></div> </div><div aria-labelledby="headingCollapsiblemiljöklimatochhållbarhet" class="collapse collapsible-item-collapse col-12" id="ccbd-miljöklimatochhållbarhet"><div class="pt-2"> <div class="collapsible-item-body"><p>Stockholms universitet har höga ambitioner avseende miljöarbetet vilket du kan läsa mer om i <a href="https://www.su.se/miljo/om-milj%C3%B6arbetet/milj%C3%B6policy/stockholms-universitets-milj%C3%B6policy-1.128804">miljöpolicyn</a>.&nbsp;Förbättringstakten i arbetet bestäms i sin tur med hjälp av miljömål och universitetets centrala <a href="https://www.su.se/miljo/om-milj%C3%B6arbetet/m%C3%A5l-och-plan">miljöhandlingsplan</a>.</p>

                            <p>Det finns tio utpekade områden där universitetet har en betydande miljöpåverkan. Några av dem är energianvändning, avfallshantering, kemikalieanvändning och tjänsteresor.</p>

                            <p>Du som är student kan bidra till universitetets miljöarbete genom att framför allt tänka på följande:</p>

                            <ul>
                                <li>Sortera ditt avfall på någon av universitetets källsorteringsstationer.</li>
                                <li>Hjälp till att släcka belysning och stänga av elektriska apparater.</li>
                                <li>Välj att cykla eller promenera till och från universitetet.</li>
                                <li>Minska dina pappersutskrifter.</li>
                                <li>Använd medhavd termosmugg istället för engångsmugg.</li>
                            </ul>

                            <h3>Vill du engagera dig i miljöarbetet?</h3>

                            <p>Miljörådet är universitetets styrgrupp för det systematiska miljöarbetet. De fattar beslut om frågor som rör miljöarbetet och ansvarar för samordningen. Miljörådet träffas cirka tio gånger om året för att besluta om frågor som rör Stockholms universitets miljöarbete.&nbsp;</p>

                            <p>Vill du engagera dig ytterligare i miljöarbetet? Genom att bli studentledamot i Miljörådet kan du vara med och påverka miljö- och hållbarhetsfrågor vid universitetet. Kontakta <a href="https://www.sus.su.se/sus-kansli" target="_blank">Stockholms universitets studentkår</a> för mer information.</p>

                            <p>Studentorganisationen <a href="https://www.sus.su.se/studentfreningar-p-su/symbios">Symbios</a>&nbsp;drivs av studenter som är intresserade av miljö och hållbarhet. Symbios organiserar föreläsningar, workshoppar och större evenemang vid universitetet.</p>

                            <p>Om du har frågor eller förslag om miljöarbetet vid universitetet, kan du också kontakta <a href="mailto:miljo@su.se">miljo@su.se</a>.</p>
                        </div> </div> </div> </div><div class="ck-collapsible-section no-gutters collapsible-item" id="Collapsiblestudentkårerna"><div class="d-flex justify-content-between"> <div class="collapsible-item-heading" id="headingCollapsiblestudentkårerna"><span class="su-anchor" id="studentkårerna">&nbsp;</span><h2 class="collapsible-item-title collapsible-item-title-link">Studentkårerna</h2> </div><div class="text-right"><button aria-controls="ccbd-studentkårerna" aria-expanded="false" aria-pressed="false" class="collapsed collapsible-item-title-link-icon button-remove-style link-styled su-js-toggle-btn" data-toggle="collapse" type="button" aria-label="Visa mer"><span class="not-pressed">&nbsp;</span> <span class="pressed">&nbsp;</span></button></div> </div><div aria-labelledby="headingCollapsiblestudentkårerna" class="collapse collapsible-item-collapse col-12" id="ccbd-studentkårerna"><div class="pt-2"> <div class="collapsible-item-body"><p>Vid Stockholms universitet finns det tre&nbsp;studentkårer: Stockholms universitets studentkår (SUS),&nbsp;studentkåren DISK och Föreningen Ekonomerna.&nbsp;DISK riktar sig till dig som studerar&nbsp;vid Data- och systemvetenskapliga&nbsp;institutionen (DSV) och Föreningen Ekonomerna riktar sig till dig som studerar vid Företagsekonomiska institutionen.</p>

                            <p>Ett av studentkårernas huvuduppdrag är att företräda studenternas gemensamma intressen och arbeta för att garantera dig och andra studenter inflytande över er utbildning. Läs mer om det under rubriken "Påverka din utbildning" ovan.&nbsp;</p>

                            <h3>Studentombuden</h3>

                            <p>På Stockholms universitets studentkår arbetar studentombud som kan besvara dina frågor kring studenträttigheter. Studentombuden kan även stötta eller företräda dig i ärenden där du upplever att dina rättigheter inte tillgodosetts.</p>

                            <p><a class="ck-external-arrow-link" href="https://www.sus.su.se/sus-ombud-din-trygghet-vid-studierelaterade-problem">Läs mer om studentombud</a></p>

                            <h3>DISK:s studerandeskyddsombud</h3>

                            <p>DISK har&nbsp;studerandeskyddsombud som finns till för att hjälpa studenterna på DSV&nbsp;med de olika problem som kan dyka upp i studiemiljön.</p>

                            <p><a class="ck-external-arrow-link" href="https://disk.su.se/studentstod/#studerandeskyddsombud" target="_blank">Läs mer om DISK:s studerandeskyddsombud</a></p>

                            <h3>Föreningen Ekonomernas studentombud och studerandeskyddsombud</h3>

                            <p>Föreningen Ekonomerna har studentombud och studerandeskyddsombud som från 1 juli nås via e-postadressen <a href="mailto:studentombud@fest.se">studentombud@fest.se</a>.</p>

                            <h3>Kontaktuppgifter</h3>

                            <p>Kontaktuppgifter till kårens medarbetare hittar du på respektive kårs webbplats:&nbsp;</p>

                            <p><a class="ck-external-arrow-link" href="https://www.sus.su.se/sus-kansli" target="_blank">Stockholms universitets studentkår</a></p>

                            <p><a class="ck-external-arrow-link" href="https://disk.su.se/" target="_blank">DISK</a></p>

                            <p><a class="ck-external-arrow-link" href="https://fest.se/" target="_blank">Föreningen Ekonomerna</a></p>
                        </div> </div> </div> </div><span class="su-anchor" id="kontakt">&nbsp;</span><h2>Kontakt</h2><p><strong>Studentavdelningen<br>
                    E-post:&nbsp;</strong><a href="mailto:studentavdelningen@su.se">studentavdelningen@su.se</a></p>


            <!-- Article info -->
            <div class="webb2021-article-info">
                <p>Senast uppdaterad: 30 juni 2022</p>
                <p>Sidansvarig: Studentavdelningen och Rektors kansli</p>
            </div>
            <!-- /Article info -->        </article>
    </div>
</div>

<script>
    $(document).ready(function (e) {
        var trigger = $('.hamburger'),
            overlay = $('.overlay'),
            isClosed = false;
        hamburger_init();

        function hamburger_init() {
            //overlay.hide();
            trigger.removeClass('is-closed');
            trigger.addClass('is-open');
            //overlay.show();
            trigger.removeClass('is-closed');
            trigger.addClass('is-open');
            isClosed = true;
            $('#wrapper').toggleClass('toggled');
        }
    });

</script>
@endsection
