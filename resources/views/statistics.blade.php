<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid gap-6 lg:grid-cols-2 lg:gap-8">
    <x-formTile title="Create Order Statistic"
                text="Select your needed Sorting and Filter Params for your Order statistic"
    >
        <x-slot:childs>
            <form method="get" action="{{route('dashboard.fetch-statistic')}}" name="fetch-statistic"
                  id="fetch-statistic">
                <div class="flex justify-between dark:text-white">
                    <div>
                        <label class="text-sm/relaxed" for="period">Choose a period:</label>
                        <div class="grid grid-cols-2 gap-x-4">
                            <div>
                                <input type="checkbox" id="day" name="period-day"
                                       @if(isset($orderCounts['day'])||isset($orderSales['day'])||isset($customerCounts['day'])) checked @endif
                                />
                                <label for="day">Day</label>
                            </div>
                            <div>
                                <input type="checkbox" id="week" name="period-week"
                                       @if(isset($orderCounts['week'])||isset($orderSales['week'])||isset($customerCounts['week'])) checked @endif

                                />
                                <label for="week">week</label>
                            </div>
                            <div>
                                <input type="checkbox" id="month" name="period-month"
                                       @if(isset($orderCounts['month'])||isset($orderSales['month'])||isset($customerCounts['month'])) checked @endif
                                />
                                <label for="month">Month</label>
                            </div>
                            <div>
                                <input type="checkbox" id="year" name="period-year"
                                       @if(isset($orderCounts['year'])||isset($orderSales['year'])||isset($customerCounts['year'])) checked @endif
                                />
                                <label for="year">Year</label>
                            </div>
                            <div>
                                <input type="checkbox" id="all" name="period-all"
                                       @if(isset($orderCounts['all'])||isset($orderSales['all'])||isset($customerCounts['all'])) checked @endif
                                />
                                <label for="all">all</label>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="text-sm/relaxed" for="data">Select the Data Values:</label>
                        <div class="grid grid-cols-2 gap-x-4">
                            @if(isset($userRights) && str_contains($userRights, 'order-count'))
                                <div>
                                    <input type="checkbox" id="order-count" name="data-order-count"
                                           @if(!empty($orderCounts)) checked @endif/>
                                    <label for="order-count">Order Count</label>
                                </div>
                            @endif
                            @if(isset($userRights) && str_contains($userRights, 'order-sales'))
                                <div>
                                    <input type="checkbox" id="order-sales" name="data-order-sales"
                                           @if(!empty($orderSales)) checked @endif/>
                                    <label for="order-sales">Order Sales</label>
                                </div>
                            @endif
                            @if(isset($userRights) && str_contains($userRights, 'customer-count'))
                                <div>
                                    <input type="checkbox" id="customer-count" name="data-customer-count"
                                           @if(!empty($customerCounts)) checked @endif/>
                                    <label for="customer-count">Customer Count</label>
                                </div>
                            @endif
                        </div>
{{--                            <div class="text-red-600">Your user account does not have any rights for data analysis. Please contact the administrator.</div>--}}
                    </div>

                </div>
                <div class="flex justify-center">
                    <x-button btnText="Create Data Statistic"/>
                </div>
            </form>
        </x-slot>
    </x-formTile>
    @if((isset($orderSales) && count($orderSales)> 1)||(isset($orderCounts)&& count($orderCounts)>1)||( isset($customerCounts)&& count($customerCounts)>1))
        <x-formTile title="Statistic results" text="Here are the selected Statistics shown">
            <x-slot:childs>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white text-black dark:bg-black dark:text-white">
                        <thead>
                        <tr class="bg-gray-200 dark:bg-gray-700">
                            <th class="py-2 px-4 border-b dark:border-gray-600" id="head"></th>
                            @foreach(count($orderCounts)>1 ? $orderCounts : (count($orderSales)>1? $orderSales:$customerCounts) as $key => $value)
                                <th class="py-2 px-4 border-b dark:border-gray-600"
                                    id='head-{{$key}}'>{{$key}}</th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($orderSales) > 1)
                            <tr class="border-b dark:border-gray-600">
                                <th class="py-2 px-4 border-b dark:border-gray-600" id="data">Order Sales</th>
                                @foreach($orderSales as $key => $value)
                                    <td class="py-2 px-4 border-b dark:border-gray-600"
                                        id='data-{{$value}}'>{{$value}}</td>
                                @endforeach
                            </tr>
                        @endif
                        @if(count($orderCounts) > 1)
                            <tr class="border-b dark:border-gray-600">
                                <th class="py-2 px-4 border-b dark:border-gray-600" id="data">Order Count</th>
                                @foreach($orderCounts as $key => $value)
                                    <td class="py-2 px-4 border-b dark:border-gray-600"
                                        id='data-{{$value}}'>{{$value}}</td>
                                @endforeach
                            </tr>
                        @endif
                        @if(count($customerCounts) > 1)
                            <tr class="border-b dark:border-gray-600">
                                <th class="py-2 px-4 border-b dark:border-gray-600" id="data">Customer Count</th>
                                @foreach($customerCounts as $key => $value)
                                    <td class="py-2 px-4 border-b dark:border-gray-600"
                                        id='data-{{$value}}'>{{$value}}</td>
                                @endforeach
                            </tr>
                        @endif
                        </tbody>
                    </table>
                    <div class="inline-flex justify-between items-center w-full">
                        <h1 class="dark:text-white">Fetch Stats as: </h1>
                        @php
                            $jsonOrderData = "";
                                if (isset($orderCounts)){
                                    $jsonOrderData .= json_encode($orderCounts);
                                }
                                 if (isset($orderSales)){
                                    $jsonOrderData .= json_encode($orderSales);
                                }
                                 if (isset($customerCounts)){
                                    $jsonOrderData .= json_encode($customerCounts);
                                }
                        @endphp
                        <form method="get" action='{{route('dashboard.download', ['json'])}}'>
                            <x-button btnValue='{{$jsonOrderData}}' btnText="JSON"/>
                        </form>
                        <form method="get" action='{{route('dashboard.download',['csv'])}}'>
                            <x-button btnValue='{{$jsonOrderData}}' btnText="CSV"/>
                        </form>
                        <form method="get" action='{{route('dashboard.download',['pdf'])}}'>
                            <x-button btnValue='{{$jsonOrderData}}' btnText="PDF"/>
                        </form>
                    </div>
                </div>
            </x-slot:childs>
        </x-formTile>
    @endif
    @if(isset($orderSales) && count($orderSales) > 0)
        <x-formTile title="Order Sales Chart">
            <x-slot:childs>
                <div class="w-full mt-4">
                    <canvas id="chart-sales"></canvas>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function () {

                        const ctx = document.getElementById('chart-sales');

                        const orderSalesData = {!! json_encode($orderSales) !!};
                        const parsedOrderSalesData = Object.keys(orderSalesData).map(key => {
                            return {
                                label: key,
                                value: parseFloat(orderSalesData[key].replace('€', '').replace('.', '').replace(',', '.'))
                            };
                        });

                        new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: parsedOrderSalesData.map(item => item.label),
                                datasets: [{
                                    data: parsedOrderSalesData.map(item => item.value),
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: false,
                                    title: false
                                }
                            }
                        });
                    })
                </script>
            </x-slot:childs>
        </x-formTile>
    @endif
    @if(isset($orderCounts) && count($orderCounts) > 0)
        <x-formTile title="Order Counts Chart">
            <x-slot:childs>

                <div class="w-full mt-4">
                    <canvas id="chart-Counts"></canvas>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function () {

                        const ctx = document.getElementById('chart-Counts');

                        const orderCountsData = {!! json_encode($orderCounts) !!};
                        const parsedOrderCountsData = Object.entries(orderCountsData).map(([label, value]) => ({
                            label,
                            value
                        }));

                        new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: parsedOrderCountsData.map(item => item.label),
                                datasets: [{
                                    data: parsedOrderCountsData.map(item => item.value),
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: false,
                                    title: false
                                }
                            }
                        });
                    })
                </script>
            </x-slot:childs>
        </x-formTile>
    @endif
    @if(isset($customerCounts) && count($customerCounts) > 0)
        <x-formTile title="Customer Counts Chart">
            <x-slot:childs>

                <div class="w-full mt-4">
                    <canvas id="chart-Customers"></canvas>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function () {

                        const ctx = document.getElementById('chart-Customers');

                        const customerCountsData = {!! json_encode($customerCounts) !!};
                        const parsedcustomerCountsData = Object.entries(customerCountsData).map(([label, value]) => ({
                            label,
                            value
                        }));

                        new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: parsedcustomerCountsData.map(item => item.label),
                                datasets: [{
                                    data: parsedcustomerCountsData.map(item => item.value),
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: false,
                                    title: false
                                }
                            }
                        });
                    })
                </script>
            </x-slot:childs>
        </x-formTile>
    @endif
</div>
