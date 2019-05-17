declare
	
	@v_cont_Chevrolet int,
	@v_cont_Fiat int,
	@v_cont_Ford int,
	@v_cont_Honda int,
	@v_cont_Toyota int,
	@v_cont_total int
	
begin
	/* método 1 - O select tem que retornar um simples coluna e um único resultado*/
	-- o set atribui a variável o resultado de uma query
	set @v_cont_Chevrolet = (select count(idCarros) from carros where montadora='Chevrolet')
	set @v_cont_Fiat = (select count(idCarros) from carros where montadora='Fiat')
	set @v_cont_Ford = (select count(idCarros) from carros where montadora='Ford')
	set @v_cont_Honda = (select count(idCarros) from carros where montadora='Honda')
	set @v_cont_Toyota = (select count(idCarros) from carros where montadora='Toyota')
	set @v_cont_total = (select count(idCarros) from carros)
	
	print 'MÉTODO 1:'
	print 'Modelos Chevrolet: '+ cast(@v_cont_Chevrolet as varchar)
	print 'Modelos Fiat: '+ cast(@v_cont_Fiat as varchar)
	print 'Modelos Ford: '+ cast(@v_cont_Ford as varchar)
	print 'Modelos Honda: '+ cast(@v_cont_Honda as varchar)
	print 'Modelos Toyota: '+ cast(@v_cont_Toyota as varchar)
	print 'Total de carros: '+ cast(@v_cont_total as varchar) 
		
		
	/* método 2 -  Utilizamos a variável dentro do select para definir o seu valor*/
	
	select @v_cont_Chevrolet = count(idCarros) from carros where montadora='Chevrolet'
	select @v_cont_Fiat = count(idCarros)from carros where montadora='Fiat'
	select @v_cont_Ford = count(idCarros)from carros where montadora='Ford'
	select @v_cont_Honda = count(idCarros)from carros where montadora='Honda'
	select @v_cont_Toyota = count(idCarros)from carros where montadora='Toyota'
	select @v_cont_total = count(idCarros) from carros
			
	print 'MÉTODO 2:'
	print 'Modelos Chevrolet: '+ cast(@v_cont_Chevrolet as varchar)
	print 'Modelos Fiat: '+ cast(@v_cont_Fiat as varchar)
	print 'Modelos Ford: '+ cast(@v_cont_Ford as varchar)
	print 'Modelos Honda: '+ cast(@v_cont_Honda as varchar)
	print 'Modelos Toyota: '+ cast(@v_cont_Toyota as varchar)
	print 'Total de carros: '+ cast(@v_cont_total as varchar)
	
end
go