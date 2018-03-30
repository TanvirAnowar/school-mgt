@extends('templates.bucket.bucket')

@section('wrapper')
<section class="wrapper">
    {{Helpers::showMessage()}}
    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    Create Income Statement
                        <span class="tools pull-right">
                           <!-- <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-cog"></a>
                            <a href="javascript:;" class="fa fa-times"></a>-->

                         </span>
                </header>
                <div class="panel-body">
                    <form id="searchIncomeStatementFrm"class="form-horizontal">
                        <div class="form-group">
                            <label class="control-label col-lg-3">Search By</label>
                            <div class="col-lg-2">
                                <select class="form-control" name="search_by">
                                    <option value="">--SELECT--</option>
                                    <option value="month">Month</option>
                                    <option value="date_range">Date Range</option>
                                </select>   
                            </div>
                        </div>
                        <div class="form-group hide" id="month">
                            <label class="control-label col-lg-3">Month</label>
                            <div class="col-lg-2">
                                <select class="form-control" name="month" required>
                                    <option value="">--SELECT--</option>
                                    <?php $months = array('01'=>'January','02'=>'February','03'=>'March','04'=>'April','05'=>'May','06'=>'June','07'=>'July','08'=>'August','09'=>'September','10'=>'October','11'=>'November','12'=>'December'); ?>
                                    @foreach($months as $k=> $month)
                                    <option value="{{$k}}">{{$month}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <label class="control-label col-lg-1">Year</label>
                            <div class="col-lg-2">
                                <select class="form-control" name="year" required>
                                    <option value="">--SELECT--</option>
                                    @for($i=(date('Y')-5); $i<=(date('Y')+5); $i++)
                                    <option @if($i==date('Y')) selected @endif value="{{$i}}">{{$i}}</option>
                                    @endfor
                                </select>
                            </div>
                           <!--  <div class="col-lg-1">
                                <button id="searchIncomeStatement" type="button" class="btn btn-primary">Search</button>
                            </div> -->

                        </div>
                        <div class="form-group hide" id="date_range">
                            <label class="control-label col-lg-3">Date From</label>
                            <div class="col-lg-2">
                               <input type="text" class="form-control input-medium default-date-picker" name="date_from" required />
                            </div>

                            <label class="control-label col-lg-1">Date To</label>
                            <div class="col-lg-2">
                                <input type="text" class="form-control input-medium default-date-picker" name="date_to" required />
                            </div>
                            

                        </div>
                        <div class="form-group hide">
                            <div class="col-lg-3 col-lg-offset-3">
                                    <button id="searchIncomeStatement" type="button" class="btn btn-primary">Search</button>
                            </div>
                        </div>
                    </form>
                    <form action="#">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th colspan="3">Expenses:</th>

                                </tr>
                            </thead>
                            <tbody class="expenses">

                            </tbody>
                            <thead>
                                <tr>
                                    <th colspan="3">Income:</th>

                                </tr>
                            </thead>
                            <tbody class="incomes">

                            </tbody>
                            <thead>
                            <tr>
                                <th colspan="3">Net Profit/Loss:</th>

                            </tr>
                            </thead>
                            <tbody class="net_cal">

                            </tbody>
                        </table>
                        <div class="col-lg-3">
                            <button id="saveIncomeStatementBtn" type="button" class="btn btn-primary hide">Save</button>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>
</section>
<script src="{{$theme}}js/custom/common.js"></script>
<script type="text/javascript">
    var expenses = '';
    var incomes = '';
    var totalExpense = 0;
    var totalIncome = 0;
    var netTotal = 0;
    var profitLoss = '';
    var incomeStatementYear = '';
    var incomeStatementMonth = '';
    $(function(){
       
       $("body").on('click','a.headToggle',function(){
            var obj = $(this);
            var trToToggle = obj.attr('href').replace('#','');
            if(obj.hasClass('visible'))
            {
                $('tr.'+trToToggle).addClass('hide');
                obj.removeClass('visible');
                obj.children().addClass('fa-plus').removeClass('fa-minus');
                if($("tr."+trToToggle+'> td').children('a').length)   
                {
                    var subTrToToggle = $("tr."+trToToggle+'> td').children('a').attr('href').replace('#','');                  
                     $('tr.'+subTrToToggle).addClass('hide');
                     
                     $("tr."+trToToggle+'> td').children('a').removeClass('visible');
                     $("tr."+trToToggle+'> td').children('a').children().addClass('fa-plus').removeClass('fa-minus');
                }   
            }else{
                
                $('tr.'+trToToggle).removeClass('hide');
                obj.addClass('visible');
                obj.children().addClass('fa-minus').removeClass('fa-plus');
                 
            }
            return false;
       });

       $("select[name='search_by'],select[name='month'],select[name='year']").change(function(){
           $("table tbody.expenses").children().remove();
             $("table tbody.incomes").children().remove();
             $("table tbody.net_cal").children().remove();
             totalExpense = 0;
             totalIncome  = 0;
             expenseTr = '';
             incomeTr = '';
       })

       $("#searchIncomeStatement").click(function(){
            var searchBy = $("select[name='search_by']");
            $("table tbody.expenses").children().remove();
                         $("table tbody.incomes").children().remove();
                         $("table tbody.net_cal").children().remove();
            var formSubmit = true;
            if(searchBy.val())
            {


               if(searchBy.val() == 'month')
               { 
                    var month = $("select[name='month']").val();
                    var year = $("select[name='year']").val();
                    
                    if(month == "" || year == "")
                        formSubmit = false;
                }
                else
                {
                    var date_from = $("input[name='date_from']").val();
                    var date_to   = $("input[name='date_to']").val();
                    
                    if(date_from == "" || date_to == "")
                        formSubmit = false;
                }

               if(formSubmit)
               {
                   $.ajax({
                     type:"POST",
                     url : BASE+'finance/income-statement/get',
                     data:$("#searchIncomeStatementFrm").serialize(),
                     beforeSend:function(e){
                         $("table tbody.expenses").children().remove();
                         $("table tbody.incomes").children().remove();
                         $("table tbody.net_cal").children().remove();
                         totalExpense = 0;
                         totalIncome  = 0;
                         expenseTr = '';
                         incomeTr = '';
                     },
                     success:function(e)
                     {
                        var data = $.parseJSON(e);
                        /*var expenseTr = '';
                        var incomeTr = '';*/

                        for(ex in data.expenses)
                        {
                            
                            var expense = data.expenses[ex];
                               
                            var className = ex.toLowerCase().replace(/\s/g,'_');
                           
                            expenseTr += '<tr style="background:#C1D0FF;font-weight:bold;">';
                            expenseTr += '<td>';
                            if(Object.keys(expense.collection).length)
                                expenseTr += ' <a class="headToggle" href="#'+className+'"><i class="fa fa-plus"></i></a> ';
                            expenseTr += expense.head+'</td>';
                            expenseTr += '<td>'+expense.description+'</td>';
                            expenseTr += '<td class="text-right">'+expense.amount+'</td>';
                            expenseTr += '</tr>';
                            
                            
                           
                            if(Object.keys(expense.collection).length){
                                for(item in expense.collection){  
                                    transactions = expense.collection[item];
                                    month = item;
                                    classNameMonth = className+'_'+month;
                                    expenseTr += '<tr class="'+className+' hide"><td style="background:#e2f1ff;" colspan="2">&nbsp;&nbsp;';
                                    if(transactions.collection.length)
                                    expenseTr += '<a class="headToggle" href="#'+classNameMonth+'"><i class="fa fa-plus"></i></a> ';
                                    expenseTr += month + '</td>';
                                    expenseTr += '<td style="background:#e2f1ff;" class="text-right">'+transactions.total+'</td>';
                                    expenseTr += '</tr>';
                                    if(transactions.collection.length){
                                        for(t in transactions.collection)
                                        {
                                            transaction = transactions.collection[t]; 
                                           
                                            expenseTr +='<tr class="'+ classNameMonth+' hide">';
                                             expenseTr += '<td>&nbsp;&nbsp;&nbsp;&nbsp;'+transaction.to.name+'</td>';
                                             expenseTr += '<td>'+transaction.date+'</td>';
                                             expenseTr += '<td class="text-right">'+transaction.amount+'</td>';
                                            expenseTr +='</tr>';
                                        }
                                    }
                                }
                            }
                        

                            totalExpense += parseFloat(expense.amount);
                        }
                        $("table tbody.expenses").append(expenseTr);
                        $("table tbody.expenses").append('<tr class="expense_total"><td colspan="2" class="text-right"><strong>Total Expense:</strong></td><td class="text-right"><strong>'+totalExpense+'</strong></td></tr>');
                        
                        for(i in data.incomes)
                        {
                            var income = data.incomes[i];
                            var className = i.toLowerCase().replace(/\s/g,'_');
                            
                            incomeTr += '<tr style="background:#C1D0FF;font-weight:bold;">';
                            incomeTr += '<td>';
                            if(Object.keys(income.collection).length)
                                incomeTr += ' <a class="headToggle" href="#'+className+'"><i class="fa fa-plus"></i></a> ';
                            incomeTr += income.head+'</td>';
                            incomeTr += '<td>'+income.description+'</td>';
                            incomeTr += '<td class="text-right">'+income.amount+'</td>';
                            incomeTr += '</tr>';
                            
                            if(Object.keys(income.collection).length){
                                for(item in income.collection){  
                                    transactions = income.collection[item];
                                    month = item;
                                    classNameMonth = className+'_'+month;
                                    incomeTr += '<tr class="'+className+' hide"><td style="background:#e2f1ff;" colspan="2">&nbsp;&nbsp;';
                                    if(transactions.collection.length)
                                    incomeTr += '<a class="headToggle" href="#'+classNameMonth+'"><i class="fa fa-plus"></i></a> ';
                                    incomeTr += month + '</td>';
                                    incomeTr += '<td style="background:#e2f1ff;" class="text-right">'+transactions.total+'</td>';
                                    incomeTr += '</tr>';
                                    if(transactions.collection.length){
                                        for(t in transactions.collection)
                                        {
                                            transaction = transactions.collection[t]; 
                                            
                                            incomeTr +='<tr class="'+classNameMonth+' hide">';
                                             incomeTr += '<td>&nbsp;&nbsp;&nbsp;&nbsp;'+transaction.to.name+'</td>';
                                             incomeTr += '<td>'+transaction.date+'</td>';
                                             incomeTr += '<td class="text-right">'+transaction.amount+'</td>';
                                            incomeTr +='</tr>';
                                        }
                                    }
                                }
                            }

                            /*if(Object.keys(income.collection).length)
                            {
                                for(item in income.collection){  
                                    transaction = income.collection[item];
                                    incomeTr +='<tr class="'+className+' hide">';
                                     incomeTr += '<td>'+transaction.to.name+'</td>';
                                     incomeTr += '<td>'+transaction.date+'</td>';
                                     incomeTr += '<td class="text-right">'+transaction.amount+'</td>';
                                    incomeTr +='</tr>';
                                }
                            }*/

                            totalIncome += parseFloat(income.amount);
                        }

                        $("table tbody.incomes").append(incomeTr);
                        $("table tbody.incomes").append('<tr class="income_total"><td colspan="2" class="text-right"><strong>Total Income:</strong></td><td class="text-right"><strong>'+totalIncome+'</strong></td></tr>');
                        $("table tbody.net_cal").append('<tr><td colspan="2" class="text-right"><strong>Total Expense:</strong></td><td class="text-right"><strong>'+totalExpense+'</strong></td></tr>');
                        $("table tbody.net_cal").append('<tr><td colspan="2" class="text-right"><strong>Total Income:</strong></td><td class="text-right"><strong> - '+totalIncome+'</strong></td></tr>');
                        netTotal = (totalExpense-totalIncome);
                        if(netTotal < 0)
                           profitLoss = 'Net Profit';
                        else
                            profitLoss = 'Net Loss';

                         $("table tbody.net_cal").append('<tr><td colspan="2" class="text-right"><strong>'+profitLoss+':</strong></td><td class="text-right"><strong>'+Math.abs(netTotal)+'</strong></td></tr>');
                         $("#saveIncomeStatementBtn").removeClass('hide');

                         expenses = data.expenses;
                         incomes  = data.incomes;
                         

                     }
                   });
                }else{
                    if(searchBy.val() == 'month')
                    {
                        alert('Please select month and year');
                    }
                    else{
                        alert('Please select Date From and Date To');
                    }     
                }
            }
       });

       $("#saveIncomeStatementBtn").click(function(){
           var searchBy         = $("select[name='search_by']").val();
           incomeStatementMonth = $("select[name='month']").val();
           incomeStatementYear  = $("select[name='year']").val();
           var dateFrom             = $("input[name='date_from']").val();
           var dateTo               = $("input[name='date_to']").val();
           
           $.ajax({
             type:"POST",
             url : BASE + 'finance/income-statement/save',
             data:{date_from:dateFrom,date_to:dateTo,search_by:searchBy,year:incomeStatementYear,month:incomeStatementMonth,expenses:expenses,incomes:incomes,totalExpense:totalExpense,totalIncome:totalIncome,netTotal:netTotal,profitLoss:profitLoss},
             success:function(e)
             {
             //   window.location = e;
             }
           });
       });

       var searchBy = $("select[name='search_by']");

       if(searchBy.val() == 'month')
            { 
                $('#month').removeClass('hide');
                $('#date_range').addClass('hide');
                $("#searchIncomeStatement").parent().parent().removeClass('hide');
               
            }else if(searchBy.val() == 'date_range'){
                $('#date_range').removeClass('hide');
                $('#month').addClass('hide');
                $("#searchIncomeStatement").parent().parent().removeClass('hide');
            }

        searchBy.change(function(){
            var obj = $(this);
            if(obj.val() == 'month')
            { 
                $('#month').removeClass('hide');
                $('#date_range').addClass('hide');
               
            }else{
                $('#date_range').removeClass('hide');
                $('#month').addClass('hide');
            }
            
            $("#searchIncomeStatement").parent().parent().removeClass('hide');
            
       });
    });
</script>
@stop