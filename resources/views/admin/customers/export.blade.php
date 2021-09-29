<table>
<thead>
  <tr>
    <th>이름 (name)</th>
    <th>전화번호(number)</th>
    <th>전화번호2(number2)</th>
    <th>성별(Gender)</th>
    <th>나이(Age)</th>
    <th>지역(City)</th>
    <th>그룹(Group)</th>
    <th>이메일(Email)</th>
    <th>알게된 경로(routs of known)</th>
    <th>증권사(stock broker)</th>
    <th>증권 계좌번호(account number)</th>
    <th>주소(Address)</th>
  </tr>
</thead>
<tbody>
  <?php $i=1; ?>
  @foreach($customers as $customer)
   
  <tr>
    <td>{{ ucfirst($customer->name) }}</td>
    <td>{{ $customer->phonenumber1 }}</td>
    <td>{{ $customer->phonenumber2 }}</td>
    <td>{{ $customer->gender=='M' ? '남' : ($customer->gender=='F' ? '여' : '기타') }}</td>
    <td>{{ $customer->age }}</td>
    <td>{{ $customer->customerCity ? $customer->customerCity->cityName : 'N/A' }}</td>
    <td>{{ $customer->customerGroup ? $customer->customerGroup->groupName : 'N/A' }}</td>
    <td>{{ $customer->email }}</td>
    <td>{{ $customer->customerRouteKnown ? $customer->customerRouteKnown->routeName : 'N/A' }}</td>
    <td>{{ $customer->stockBroker }}</td>
    <td>{{ $customer->accountNumber }}</td>
    <td>{{ $customer->address }}</td>
  </tr>
  @endforeach
</tbody>
</table>