<table class="overflow-y" id="diseaseTable">
    <thead>
        <TR>
        <TH ROWSPAN="2" class="text-center">DISEASE</TH>
        <TH ROWSPAN="2" class="text-center">ICD 10 Code</TH>
        <TH COLSPAN="2" class="text-center">Under 1</TH>
        <TH COLSPAN="2" class="text-center">1-4</TH>
        <TH COLSPAN="2" class="text-center">5-9</TH>
        <TH COLSPAN="2" class="text-center">10-14</TH>
        <TH COLSPAN="2" class="text-center">15-19</TH>
        <TH COLSPAN="2" class="text-center">20-24</TH>
        <TH COLSPAN="2" class="text-center">25-29</TH>
        <TH COLSPAN="2" class="text-center">30-34</TH>
        <TH COLSPAN="2" class="text-center">35-39</TH>
        <TH COLSPAN="2" class="text-center">40-44</TH>
        <TH COLSPAN="2" class="text-center">45-49</TH>
        <TH COLSPAN="2" class="text-center">50-54</TH>
        <TH COLSPAN="2" class="text-center">55-59</TH>
        <TH COLSPAN="2" class="text-center">60-64</TH>
        <TH COLSPAN="2" class="text-center">65-69</TH>
        <TH COLSPAN="2" class="text-center">70+</TH>
        <TH COLSPAN="3" class="text-center">TOTAL</TH>
        </TR>
        <TR>
            <TH>F</TH><TH>M</TH>
            <TH>F</TH><TH>M</TH>
            <TH>F</TH><TH>M</TH>
            <TH>F</TH><TH>M</TH>
            <TH>F</TH><TH>M</TH>
            <TH>F</TH><TH>M</TH>
            <TH>F</TH><TH>M</TH>
            <TH>F</TH><TH>M</TH>
            <TH>F</TH><TH>M</TH>
            <TH>F</TH><TH>M</TH>
            <TH>F</TH><TH>M</TH>
            <TH>F</TH><TH>M</TH>
            <TH>F</TH><TH>M</TH>
            <TH>F</TH><TH>M</TH>
            <TH>F</TH><TH>M</TH>
            <TH>F</TH><TH>M</TH>
            <TH>F</TH><TH>M</TH><TH>Total</TH>
        </TR>
    </thead>
    <tbody>
    <?php
    $count= 0;
    ?>
    @if (count($m2) > 1)
        @foreach ($m2 as $key=>$val)
            <tr>
                <th class='disease_list'>{{ $key }}</th>
                <td>{{ $val['code'] }}</td>
                <?php
                    $fcount=0;
                    $mcount=0;
                    $tcount=0;
                ?>

                @foreach ($val['details'] as $k=>$v)
                    <?php
                        $fcount += $v['F'];
                        $mcount += $v['M'];
                        $tcount += $v['F'] + $v['M'];
                    ?>
                    <td>{{ $v['F'] }}</td>
                    <td>{{ $v['M'] }}</td>
                @endforeach

                <td>{{ $fcount }}</td>
                <td>{{ $mcount }}</td>
                <td>{{ $tcount }}</td>
            </tr>
            <?php
                $count++;
            ?>
        @endforeach
    @endif
        <?php
    /*
        @foreach($diseases as $disease => $code)
        <tr>
            <td>{{ $disease }}</td>
            <td>{{ $code }}</td>
            @foreach($ageGroup as $key=>$range)
                <td>{!! AsyncWidget::run('\ShineOS\Core\Reports\Widgets\fhsisWidget',['type' => 'count', 'gender' => 'F', 'age' => $range, 'disease'=>$disease, 'disease_code'=>$code, 'month'=>$month, 'year'=>$year]) !!}</td>
                <td>{!! AsyncWidget::run('\ShineOS\Core\Reports\Widgets\fhsisWidget',['type' => 'count', 'gender' => 'M', 'age' => $range, 'disease'=>$disease, 'disease_code'=>$code, 'month'=>$month, 'year'=>$year]) !!}</td>
            @endforeach
            <td>F-T-v</td>
            <td>M-T-v</td>
        </tr>
        @endforeach*/ ?>
    </tbody>
</table>
