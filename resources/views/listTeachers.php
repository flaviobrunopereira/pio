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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.15.4/extensions/export/bootstrap-table-export.min.js" integrity="sha384-xnHFjjlTl6WNyfjM8fZXKCTn01utrBws+pDWN8tz1GJ/vLGTqUMAdJYjZjnCRMio" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.15.5/dist/bootstrap-table.min.css">
    <script src="https://unpkg.com/bootstrap-table@1.15.5/dist/bootstrap-table.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.15.4/extensions/export/bootstrap-table-export.js"></script>

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


        table.dataTable thead .sorting:after,
        table.dataTable thead .sorting:before,
        table.dataTable thead .sorting_asc:after,
        table.dataTable thead .sorting_asc:before,
        table.dataTable thead .sorting_asc_disabled:after,
        table.dataTable thead .sorting_asc_disabled:before,
        table.dataTable thead .sorting_desc:after,
        table.dataTable thead .sorting_desc:before,
        table.dataTable thead .sorting_desc_disabled:after,
        table.dataTable thead .sorting_desc_disabled:before {
            bottom: .5em;
        }

    </style>
    <!-- Custom styles for this template -->
    <link href="dashboard.css" rel="stylesheet">
</head>
<body>
<div class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="tab-pane fade show active" id="v-pills-alunos" role="tabpanel" aria-labelledby="v-pills-alunos-tab">
        <table id="table_teachers" data-search="true">
            <thead>
            <tr>
                <th data-field="employeeNumber" class="employeeNumber" data-sortable="true">Func.</th>
                <th data-field="numSGA" class="numSGA" data-sortable="true">numSGA</th>
                <th data-field="name" class="name" data-sortable="true">Nome</th> <!-- NumSGA-->
                <th data-field="email" class="emailAlt" data-sortable="true">Email</th>
                <th data-field="categoryProf" class="categoryProf" data-sortable="true">Categoria</th>
                <th data-field="higherDegree" class="higherDegree" data-sortable="true">Habilitação</th>
                <th data-field="higherDegree_course" class="higherDegree_course" data-sortable="true">Curso</th>
                <th data-field="active" class="active" data-sortable="true">Active</th>
            </tr>
            </thead>
        </table>
    </div>
</div>




<script type="text/javascript">
    $(document).ready(function () {
        $('#table_teachers').bootstrapTable({
            data: teachers
        });
    });

    var teachers=<?php echo trim($data, '\\'); ?>
</script>
