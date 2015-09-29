function CarregaToolTip(nome)
  {
      obj = document.getElementById("txtInfo")
      obj.value = "Clique sobre uma das op\u00e7\u00f5es acima para acessar as \u00e1reas configur\u00e1veis.";
      
      switch (nome)
      {
        case "bt_abertas":       
            obj.value = "Manifesta\u00e7\u00f5es em aberto, rec\u00e9m enviadas pelos usu\u00e1rios.";;
        break;
        case "bt_andamento":
            obj.value = "Acompanhe as manifesta\u00e7\u00f5es em andamento.";;
        break;
        case "bt_fechadas":
            obj.value = "Manifesta\u00e7\u00f5es que foram finalizadas.";;
        break;
        case "bt_departamentos":
            obj.value = "Cadastro de departamentos.";;
        break;
        case "bt_tipos":
            obj.value = "Cadastro de tipos de Manifesta\u00e7\u00f5es poss\u00edveis.";;
        break;
		case "bt_relatorios":
            obj.value = "Verifica\u00e7\u00e3o e emiss\u00e3o de relat\u00f3rios personalizados.";;
        break;
		case "bt_usuario":
            obj.value = "Cadastro de Usu\u00e1rios para acesso ao sistema.";;
        break;
		case "bt_clientela":
            obj.value = "Cadastro de tipos de clientela.";;
        break;
		case "bt_status":
            obj.value = "Cadastro de tipos de status das manifesta\u00e7\u00f5es.";;
        break;
		case "bt_ajuda":
            obj.value = "Menu de ajuda do VOX.";;
        break;
      }
  }