{x2;eval: v:page = 1}
{x2;sql:"select * from x2_user where userid = v:page",data}
{x2;eval: print_r(v:data)}