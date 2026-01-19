
const orders = [
    {id:2001, name:"Rafiq Karim", address:"Gulshan, Dhaka", product:"Naruto T-Shirt", qty:1, status:"Accepted"},
    {id:2002, name:"Hasib Rahman", address:"Dhanmondi, Dhaka", product:"Luffy T-Shirt", qty:2, status:"Accepted"},
    {id:2003, name:"Samiul Islam", address:"Mirpur, Dhaka", product:"Goku T-Shirt", qty:1, status:"Accepted"},
    {id:2004, name:"Rashed Chowdhury", address:"Banani, Dhaka", product:"Sasuke T-Shirt", qty:1, status:"Accepted"},
    {id:2005, name:"Fahim Ahmed", address:"Mohammadpur, Dhaka", product:"Sakura T-Shirt", qty:2, status:"Accepted"},
    {id:2006, name:"Arif Hossain", address:"Uttara, Dhaka", product:"Zoro T-Shirt", qty:1, status:"Accepted"},
    {id:2007, name:"Mamun Kabir", address:"Tejgaon, Dhaka", product:"Nami T-Shirt", qty:1, status:"Accepted"},
    {id:2008, name:"Tanvir Hasan", address:"Motijheel, Dhaka", product:"Robin T-Shirt", qty:2, status:"Accepted"},
    {id:2009, name:"Shahriar Alam", address:"Mohakhali, Dhaka", product:"Chopper T-Shirt", qty:1, status:"Accepted"},
    {id:2010, name:"Rakibul Islam", address:"Jatrabari, Dhaka", product:"Sanji T-Shirt", qty:1, status:"Accepted"},
    {id:2011, name:"Sabbir Hossain", address:"Rampura, Dhaka", product:"Lelouch T-Shirt", qty:1, status:"Accepted"},
    {id:2012, name:"Alamin Khan", address:"Bashundhara, Dhaka", product:"C.C. T-Shirt", qty:1, status:"Accepted"},
    {id:2013, name:"Imran Faruk", address:"Khilgaon, Dhaka", product:"Edward T-Shirt", qty:2, status:"Accepted"},
    {id:2014, name:"Firoz Ahmed", address:"Paltan, Dhaka", product:"Alphonse T-Shirt", qty:1, status:"Accepted"},
    {id:2015, name:"Jahidul Islam", address:"Shahbagh, Dhaka", product:"Ichigo T-Shirt", qty:1, status:"Accepted"},
    {id:2016, name:"Rakib Hasan", address:"Mirpur-10, Dhaka", product:"Rukia T-Shirt", qty:1, status:"Accepted"},
    {id:2017, name:"Sujon Hossain", address:"Uttara Sector 6, Dhaka", product:"Goku T-Shirt", qty:3, status:"Accepted"},
    {id:2018, name:"Nazmul Karim", address:"Dhanmondi, Dhaka", product:"Naruto T-Shirt", qty:2, status:"Accepted"},
    {id:2019, name:"Hasan Mahmud", address:"Gulshan-1, Dhaka", product:"Luffy T-Shirt", qty:1, status:"Accepted"},
    {id:2020, name:"Sakib Ahmed", address:"Banani, Dhaka", product:"Sasuke T-Shirt", qty:1, status:"Accepted"},
];


const tbody = document.querySelector("#myDeliveries tbody");


orders.forEach(order => {
    const tr = document.createElement("tr");
    tr.innerHTML = `
        <td>${order.id}</td>
        <td>${order.name}</td>
        <td>${order.address}</td>
        <td>${order.product}</td>
        <td>${order.qty}</td>
        <td>${order.status}</td>
    `;
    tbody.appendChild(tr);
});
