<table class="display table table-bordered table-striped" id="dynamic-table">
    <thead>
        <tr>
            <th>Select</th>
            <th>Responsible Teacher</th>
            <th>Class</th>

        </tr>
    </thead>
    <tbody>
    @if(count($teacherAssigns))
        @foreach($teacherAssigns as $id=>$assign)
            <tr>
                <td>
                    <input type="radio" name="teacher_id" value="{{{$id}}}"/>
                </td>
                <td>{{{$assign['name']}}}</td>
                <td>{{{$assign['class_name']}}}</td>

            </tr>
        @endforeach
    @endif
    </tbody>
</table>
<script type="text/javascript" language="javascript" src="{{$theme}}assets/advanced-datatable/media/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="{{$theme}}assets/data-tables/DT_bootstrap.js"></script>
<script src="{{$theme}}js/dynamic_table/dynamic_table_init.js"></script>
