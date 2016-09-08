select * 
from gr1_orders o
	join gr1_userinfo u on u.user_id=o.user_id
    join (select '' as items from dual);

select '' as items from dual;
select * from gr1_posts where id >= 5856;
select * from gr1_postmeta where  post_id = 5856;
select * from gr1_posts where post_parent = 5855;

select * from gr1_garan24_deal_statuses;
update gr1_garan24_deal_statuses set id=11 where id=5;
insert into gr1_garan24_deal_statuses(id,status,description) values
(4,'credit','Товары заказаны и выкуплены')
,(5,'delivered','Доставлено агенту')
,(6,'boxbery','Отправлено в boxberry')
,(7,'boxberyhub','Доставлено в boxberry и направляется получателю')
,(8,'shipped','Доставлено получателю')
,(9,'payed','Оплачено клиентом');


select * from gr1_postmeta where  post_id = 5821;
select * from gr1_posts p 
	join gr1_postmeta pm on pm.post_id = p.id
where p.id = 5824;

