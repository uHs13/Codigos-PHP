select conta,
		  valor,
		  charindex('d',acao) as 'Debito',
		  charindex('c',acao) as 'Credito'
from banco
go
