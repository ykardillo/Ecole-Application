
<head>
    <title> Bulletin Scolaire </title>
    <link rel="stylesheet" href="../public/assets/css/reportcard.css">
    <meta charset="UTF-8">
    <meta http-equiv="Content-type" content="text/html; charset=UTF-8">

</head>

<body >
    <table style="width:120%;">
        <tr>
            <td style="width:35%; padding-top:3%;" class=" ruban center"><span class="number"> 2020-2021 : </span><span class="arab">السنة الدراسية</span></td>
            <td style="width:10%;" class="logoArab right">
                <img class="logoArab right" src="assets/images/logoArab.png">
            </td>
            <td style="width:55%; padding-top:3%;" class="arab ruban right">جمعيةأجيال الثـقافيةللتربيةوالتعليم</td>
        </tr>


    </table>
    <table id="tab_head">
        <tr>
            <td class="borderBlack" style="text-align:right;">
            @if ($data['professeur'] != null) {{$data['professeur']->nom}} {{$data['professeur']->prenom }} @endif :Prof. 
            <span class="arab">المعلم</span></td>
            <td rowspan="3" id="titleHeaderArab">
                <div class="arab">نـتـائـج الـدورة الـدراسـيـة الأولى</div>Bulletin de la 1ere session
            </td>
        </tr>
        <tr>
            <td class="borderBlack" style="text-align:right;">{{$data['dataro'][0]->prenomEtudiant}} {{$data['dataro'][0]->nomEtudiant}} :Eleve <span class="arab">التلميذ</span></td>
        </tr>
        <tr>
            <td class="borderBlack" style="text-align:right;">{{$data['classe']->nom}} :Classe <span class="arab">القسم</span></td>
        </tr>
    </table>
    <table class="tab_dwnhead">
        <td class="info_dwnhead center" style="width:30%;">Commentaires <span class="arab">مـلاحـظـات</span></td>
        <td id="invisible"> </td>
        <td class="info_dwnhead center" style="margin-left:10%;width:20%;">Note <span class="arab">النقطة</span></td>
        <td id="invisible"> </td>

        <td class="info_dwnhead center" style="margin-left:10%;width:50%;">Matieres <span class="arab">الـمـواد الـدراســيــة</span>
        </td>
    </table>
    <table id="tab_body">
        <tr id="tap_head_body">
            <td id="tap_head_body" style="width:30%;"> </td>
            <td id="invisible2"> </td>
            <td id="tap_head_body" style="width:20%;"></td>
            <td id="invisible2"> </td>
            <td id="tap_head_body" class="righttdblack" style="width:50%;"> </td>
            <td id="invisible2"> </td>

        </tr>
        <tbody>
            @foreach ($data['dataro'] as $result)

            <tr>
                <td id="interroinfo " class="number borderBlack"></td>
                <td id="invisible"> </td>
                <td class="number center borderBlack">{{$result->avg}} </td>
                <td id="invisible"> </td>
                <td id="noteEleve" class="number righttdblack center borderBlack">
                    <span id="ecartNumber">{{$result->coefficient}}</span> {{$result->nom_fr}} | <br> <span class="arab center"> {{$result->nom_ar}} </span>
                </td>

                <td id="invisible2"> </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="foot_of_body">
                <td id="interroinfo" class="footer borderBlack"></td>
                <td id="invisible"> </td>
                <td class="borderBlack"> </td>
                <td id="invisible"> </td>
                <td class="righttdblack center number borderBlack" colspan="1"> Comportement | <span class="arab"> سلوك </span></td>
                <td id="invisible2"> </td>
            </tr>
            <tr class="foot_of_body">
                <td id="interroinfo" class="footer borderBlack"></td>
                <td id="invisible"> </td>
                <td class="borderBlack center number"> {{$data['absence'][0]->nbAbsence}}</td>
                <td id="invisible"> </td>
                <td class="number righttdblack center number borderBlack" colspan="1">Absence | <span class="arab"> غياب </span></td>
                <td id="invisible2"> </td>
            </tr>
            <tr class="foot_of_body">
                <td id="interroinfo2" class="footer borderBlack"></td>
                <td id="invisible"> </td>
                <td class="borderBlack center number "> {{$data['total']}} / {{$data['coefTotal']}} </td>
                <td id="invisible"> </td>
                <td class="righttdblack center number borderBlack" colspan="1"> Total | <span class="arab"> المـجـمـوع </span></td>
                <td id="invisible"> </td>
            </tr>

        </tfoot>
    </table>
    <table class="tab_bot">
        <tr>
            <td class="info_dwnhead arab borderBlack" style="width:30%;"> توقيع ولي الأمر</td>
            <td class="info_dwnhead arab borderBlack" style="margin-left:5%;width:20%;"> ختم و توقيع الإدارة</td>
            <td class="info_dwnhead arab borderBlack" style="margin-left:5%;width:50%;"><span>:)</span> توقيـع الأستاذ (ة</td>
        </tr>
        <tr>
            <td class="borderBlack" id="footer" style="width:30%;"> </td>
            <td class="borderBlack" id="footer" style="width:20%;"> </td>
            <td class="borderBlack" id="footer" style="width:50%;"> </td>


        </tr>

    </table>
    
    </br>
    <table id="tab_remarque_prof">

        <tr>
            <td style="width:35%; border:1px solid black; height:10px; background-color:lightgray;"> Remarque professeur :</td>
            <td class="borderBlack" style="width:100%; height:10px; border-bottom-style:none;"> </td>



        </tr>
        <tr>
            <td style="width:30%; border:1px solid black; height:10px; border-right-style:none;"> </td>
            <td class="" style="width:100%; height:80px; border-top-style:none;border-right:1px solid black; border-bottom:1px solid black; "> </td>



        </tr>


    </table>
    <table id="underfoot">
        <td id="underfoot"></td>
    </table>

    <a  class="number" id="foottext"> GENERATIONS A.S.B.L - Association culturelle pour l'education et l'enseignement
    </a>
</body>
<style>

</style>

