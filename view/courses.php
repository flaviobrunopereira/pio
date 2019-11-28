<!doctype html>
<html lang="pt">
<head>


    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="generator" content="">
    <title>GI Nonio Frontend</title>
    <link rel="canonical" href="">

    <!-- Bootstrap core CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- To be exported to CSS-->
    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>
    <!-- Custom styles for this template -->
    <link href="dashboard.css" rel="stylesheet">
</head>
<div class="bg-light">
<div class="row">

<div class="col-2">
<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
    <a class="nav-link active" id="v-pills-alunos-tab" data-toggle="pill" href="#v-pills-alunos" role="tab" aria-controls="v-pills-alunos" aria-selected="true">Lista de Alunos</a>
    <a class="nav-link" id="v-pills-alunos2018-tab" data-toggle="pill" href="#v-pills-alunos2018" role="tab" aria-controls="v-pills-alunos2018" aria-selected="true">Lista de Alunos Antigos </a>
    <a class="nav-link" id="v-pills-docentes-tab" data-toggle="pill" href="#v-pills-docentes" role="tab" aria-controls="v-pills-docentes" aria-selected="false">Lista de Funcionarios</a>
    <a class="nav-link" id="v-pills-cursos-tab" data-toggle="pill" href="#v-pills-cursos" role="tab" aria-controls="v-pills-cursos" aria-selected="false">Lista de Cursos</a>
    <a class="nav-link" id="v-pills-disciplinas-tab" data-toggle="pill" href="#v-pills-disciplinas" role="tab" aria-controls="v-pills-disciplinas" aria-selected="false">Lista de Disciplina</a>
    <a class="nav-link" id="v-pills-search-tab" data-toggle="pill" href="#v-pills-search" role="tab" aria-controls="v-pills-search" aria-selected="false">Pesquisa</a>
    <a class="nav-item nav-link"  data-toggle="pill" role="navigation" aria-controls="v-pills-nav" aria-selected="false" href="courses">nav</a>
</div></div>
<div class="col-sm-10">
<div class="tab-content" id="v-pills-tabContent">


    <div class="tab-pane fade show active" id="v-pills-alunos" role="tabpanel" aria-labelledby="v-pills-alunos-tab">
        <table id="table_students">
            <thead>
            <tr>
                <th data-field="numSGA">numSGA</th>
                <th data-field="name">Nome</th> <!-- NumSGA-->
                <th data-field="course">Curso</th>
                <th data-field="courseCode">Codigo</th>
                <th data-field="status">Estado</th>
                <th data-field="emailInt">Email Inst.</th> <!-- NumSGA-->
                <th data-field="emailAlt">Email Alt.</th>
                <th data-field="lastLectiveYear">Ult. Ano Lec.</th>
            </tr>
            </thead>
        </table>


    </div>


    <div class="tab-pane fade show" id="v-pills-alunos2018" role="tabpanel" aria-labelledby="v-pills-alunos2018-tab">
        <table id="table_students2018">
            <thead>
            <tr>
                <th data-field="numSGA">numSGA</th>
                <th data-field="name">Nome</th> <!-- NumSGA-->
                <th data-field="course">Curso</th>
                <th data-field="courseCode">Codigo</th>
                <th data-field="status">Estado</th>
                <th data-field="emailInt">Email Inst.</th> <!-- NumSGA-->
                <th data-field="emailAlt">Email Alt.</th>
                <th data-field="lastLectiveYear">Ult. Ano Lec.</th>
            </tr>
            </thead>
        </table>


    </div>





    <div class="tab-pane fade" id="v-pills-docentes" role="tabpanel" aria-labelledby="v-pills-docentes-tab">
        <table id="table_docentes">
            <thead>
            <tr>
                <th data-field="numInt">numInt</th>
                <th data-field="name">Nome</th> <!-- NumSGA-->
                <th data-field="gender">Sexo</th>
                <th data-field="categoryProf">categoryProf</th>
                <th data-field="type">Tipo</th> <!-- NumSGA-->
                <th data-field="service">Serviço</th>
                <th data-field="career">carreira</th>
                <th data-field="active">Activo</th>
                <th data-field="emailInst">Email</th>
                <th data-field="profSituation">profSituation</th>
            </tr>
            </thead>
        </table>



    </div>


    <div class="tab-pane fade" id="v-pills-cursos" role="tabpanel" aria-labelledby="v-pills-cursos-tab">

        <table id="table_courses">
            <thead>
            <tr>
                <th data-field="language">language</th>
                <th data-field="courseCode">courseCode</th> <!-- NumSGA-->
                <th data-field="courseName">courseName</th>
                <th data-field="degree">degree</th>
                <th data-field="degreeCode">degreeCode</th>
                <th data-field="courseActive">courseActive</th> <!-- NumSGA-->
                <th data-field="codeDGES">codeDGES</th>
                <th data-field="ects">ects</th>
                <th data-field="frequencyRegime">frequencyRegime</th>
                <th data-field="duration">duration</th>
            </tr>
            </thead>
        </table>


    </div>
    <div class="tab-pane fade" id="v-pills-disciplinas" role="tabpanel" aria-labelledby="v-pills-subjects-tab">
        <table id="table_subjects">
            <thead>
            <tr>
                <th data-field="language">language</th>
                <th data-field="courseCode">courseCode</th>
                <th data-field="planCode">planCode</th> <!-- NumSGA-->
                <th data-field="branchCode">branchCode</th>
                <th data-field="subjectCode">subjectCode</th>
                <th data-field="subjectName">subjectName</th>
                <th data-field="curricularYear">curricularYear</th> <!-- NumSGA-->
                <th data-field="period">period</th>
                <th data-field="ects">ects</th>
                <th data-field="mandatory">mandatory</th>
                <th data-field="internship">internship</th>
            </tr>
            </thead>
        </table>

    </div>

        <div class="tab-pane fade" id="v-pills-search" role="tabpanel" aria-labelledby="v-pills-search-tab">pesquisa de alunos</div>
</div>
</div></div>




<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.15.5/dist/bootstrap-table.min.css">
<script src="https://unpkg.com/bootstrap-table@1.15.5/dist/bootstrap-table.min.js"></script>
    <script src="extensions/export/bootstrap-table-export.js"></script>
<script type="text/javascript">

    $(function () {
        $('#table_courses').bootstrapTable({
            data: cursos
        });
    });
    var cursos =    <?php
                     $cursos  = Modelo::getCourses();
                     echo json_encode($cursos);
                     ?>

</script>

    <script type="text/javascript">
        $(function () {
            $('#table_students2018').bootstrapTable({
                data: alunos2018
            });
        });


     var alunos2018 =    <?php
    $alunos2018  = Modelo::getStudents();
    echo json_encode($alunos2018);?>

    </script>


    <script type="text/javascript">
        $(function () {
            $('#table_docentes').bootstrapTable({
                data: teachers
            });
        });


        var teachers=    <?php
        $teachers  = Modelo::getTeachers();
        echo json_encode($teachers);?>
    </script>

    <script type="text/javascript">
        $(function () {
            $('#table_subjects').bootstrapTable({
                data: subjects
            });
        });


        var subjects=    <?php
        $subjects  = Modelo::getSubjects();
        echo json_encode($subjects);?>
    </script>


</body>
</html>