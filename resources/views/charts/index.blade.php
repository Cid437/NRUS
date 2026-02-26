<!DOCTYPE html>
<html>
<head>
    <title>Charts</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<h1>Sales Charts</h1>
<canvas id="yearly"></canvas>
<canvas id="monthly"></canvas>
<canvas id="range"></canvas>
<canvas id="pie"></canvas>
<script>
async function fetchData(url){let r=await fetch(url);return r.json();}
fetchData('/charts/yearly').then(data=>{new Chart(document.getElementById('yearly'),{type:'line',data:{labels:data.map(i=>i.year),datasets:[{label:'Sales',data:data.map(i=>i.total)}]}});});
fetchData('/charts/monthly').then(data=>{new Chart(document.getElementById('monthly'),{type:'bar',data:{labels:data.map(i=>i.year+'-'+i.month),datasets:[{label:'Sales',data:data.map(i=>i.total)}]}});});
fetchData('/charts/range?from=&to=').then(data=>{new Chart(document.getElementById('range'),{type:'bar',data:{labels:data.map(i=>i.date),datasets:[{label:'Sales',data:data.map(i=>i.total)}]}});});
fetchData('/charts/pie').then(data=>{new Chart(document.getElementById('pie'),{type:'pie',data:{labels:data.map(i=>i.name),datasets:[{data:data.map(i=>i.total)}]}});});
</script>
</body>
</html>