package jonathan.aplicativoifsp;

import android.content.Intent;
import android.os.AsyncTask;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ListView;
import android.widget.ProgressBar;
import android.widget.TextView;

import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.DataOutputStream;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;
import java.sql.Array;
import java.util.ArrayList;

public class CadastroActivity extends AppCompatActivity {

    Button btn_pesquisa;

    Button btn_cadastro;
    String webservice;
    EditText txt_email;
    EditText txt_nome;
    EditText txt_cpf;
    EditText txt_rg;
    EditText txt_idade;
    EditText txt_genero;
    EditText txt_telefone;
    EditText txt_facebook;
    EditText txt_instagram;
    EditText txt_senha;
    EditText txt_id_rotina;
    TextView tvRespostaServidor;

    ListView lista;

    String nome="cc";

    Integer ID;
    Integer aux=0;
    Integer quant_rotina;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_cadastro);

        btn_pesquisa = (Button) findViewById(R.id.btn_pesquisa);

        btn_cadastro = (Button) findViewById(R.id.btn_cadastro);
        webservice = "http://192.168.0.41/Projeto/cadastro/tela_cadastro_pac.php";
        txt_email = (EditText) findViewById(R.id.txt_email);
        txt_nome = (EditText) findViewById(R.id.txt_nome);
        txt_cpf = (EditText) findViewById(R.id.txt_cpf);
        txt_rg = (EditText) findViewById(R.id.txt_rg);
        txt_idade = (EditText) findViewById(R.id.txt_idade);
        txt_genero = (EditText) findViewById(R.id.txt_genero);
        txt_telefone = (EditText) findViewById(R.id.txt_telefone);
        txt_facebook = (EditText) findViewById(R.id.txt_facebook);
        txt_instagram = (EditText) findViewById(R.id.txt_instagram);
        txt_senha = (EditText) findViewById(R.id.txt_senha);
        txt_id_rotina = (EditText) findViewById(R.id.txt_id_rotina);
        tvRespostaServidor = (TextView) findViewById(R.id.tvRespostaServidor);

        lista = (ListView) findViewById(R.id.lista);

        ArrayList<String> rotina = consulta();

        ArrayAdapter<String> arrayAdapter = new ArrayAdapter<String>(this,android.R.layout.simple_list_item_1, rotina);
        lista.setAdapter(arrayAdapter);
        btn_cadastro.setOnClickListener(new View.OnClickListener() {
          @Override
            public void onClick(View view) {

              //chamo minha asynctask que vai contactar o servidor PHP
              //new threadAssincronaParaAcessarServidor().execute();
            }
        });

        btn_pesquisa.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {


                new rotinas().execute();

                new a().execute();








                //chamo minha asynctask que vai contactar o servidor PHP
                //new threadAssincronaParaAcessarServidor().execute();

            }
        });

    }


   public ArrayList<String> consulta() {



        ArrayList<String> dados= new ArrayList<String>();




        dados.add(nome);




        return dados;
    }




    // Esta é funcao que possui a lógica para acessar o servidor PHP
    //Retorna TRUE se login feito com sucesso - FALSE, caso contrario
    private boolean enviarRequisicaoHTTPPost() throws Exception {

        URL obj = new URL(webservice.toString());
        HttpURLConnection con = (HttpURLConnection) obj.openConnection();

        //add request header
        con.setRequestMethod("POST");
        con.setDoOutput(true);


        //Gerando o objeto em JSON com os dados de login informados pelo usuario
        JSONObject acao = new JSONObject();
        JSONObject parametros = new JSONObject();

        parametros.put("nome", txt_nome.getText().toString());
        parametros.put("email", txt_email.getText().toString());
        parametros.put("cpf", txt_cpf.getText().toString());
        parametros.put("rg", txt_rg.getText().toString());
        parametros.put("idade", txt_idade.getText().toString());
        parametros.put("genero", txt_genero.getText().toString());
        parametros.put("telefone", txt_telefone.getText().toString());
        parametros.put("facebook", txt_facebook.getText().toString());
        parametros.put("instagram", txt_instagram.getText().toString());
        parametros.put("senha", txt_senha.getText().toString());
        parametros.put("id_rotina", txt_id_rotina.getText().toString());

        acao.put("acao", "efetuar_cadastro");
        acao.put("parametros", parametros);

        Log.i("***Enviando requisicao POST para servidor PHP: ", acao.toString());


        // Send post request
        con.setDoOutput(true);
        DataOutputStream wr = new DataOutputStream(con.getOutputStream());
        wr.writeBytes(acao.toString());
        wr.flush();
        wr.close();

        BufferedReader in = new BufferedReader(new InputStreamReader(con.getInputStream()));
        StringBuffer response = new StringBuffer();

        String inputLine;
        while ((inputLine = in.readLine()) != null) {
            response.append(inputLine);
        }
        in.close();

        //Imprimindo resultado recebido do servidor
        Log.i("***** Resposta do servidor PHP", response.toString());

        JSONObject resposta_json = new JSONObject(response.toString());

        boolean login_realizado_com_sucesso = false;
        if (resposta_json.getString("acao").equals("efetuar_cadastro")) {
            if (resposta_json.getInt("resultado") == 1) {
                login_realizado_com_sucesso = true;
            }
        }


        if (login_realizado_com_sucesso)
            return true;
        else
            return false;
    }


    //Esta tarefa é assincrona - acessa o servidor remoto PHP e não trava a app android
    private class threadAssincronaParaAcessarServidor extends AsyncTask<Void, Void, Integer> {

        boolean resposta;

        @Override
        protected Integer doInBackground(Void... voids) {

            try {
                resposta = enviarRequisicaoHTTPPost();
                if (resposta) {
                    return 1;
                } else {
                    return 0;
                }
            } catch (Exception e) {
                e.printStackTrace();
                return -1;
            }
            /*
            Eu estou considerando o seguinte:
            Retorno 1 para informar que login foi feito com sucesso
            Retorno 0 para informar que login estava incorreto
            Retorno -1, caso tenha ocorrido algum problema ao acessar o servidor
             */

        }


        //Utilizo isso apenas para atualizar os componentes da tela
        @Override
        protected void onPostExecute(Integer result) {


            switch (result) {
                case 0:
                    tvRespostaServidor.setText("Login incorreto. Tente novamente");
                    break;
                case 1:
                    Intent i = new Intent(CadastroActivity.this, MainActivity.class);
                    startActivity(i);
                    break;
                case -1:
                    tvRespostaServidor.setText("Ocorreu um erro ao acessar o servidor");
            }
        }

    }


    private boolean b() throws Exception {

        URL obj = new URL(webservice.toString());
        HttpURLConnection con = (HttpURLConnection) obj.openConnection();

        //add request header
        con.setRequestMethod("POST");
        con.setDoOutput(true);


        //Gerando o objeto em JSON com os dados de login informados pelo usuario
        JSONObject acao = new JSONObject();
        JSONObject parametros = new JSONObject();

        parametros.put("rotina", quant_rotina);

        acao.put("acao", "consulta_rotina");
        acao.put("parametros", parametros);

        Log.i("***Enviando requisicao POST para servidor PHP: ", acao.toString());


        // Send post request
        con.setDoOutput(true);
        DataOutputStream wr = new DataOutputStream(con.getOutputStream());
        wr.writeBytes(acao.toString());
        wr.flush();
        wr.close();

        BufferedReader in = new BufferedReader(new InputStreamReader(con.getInputStream()));
        StringBuffer response = new StringBuffer();

        String inputLine;
        while ((inputLine = in.readLine()) != null) {
            response.append(inputLine);
        }
        in.close();

        //Imprimindo resultado recebido do servidor
        Log.i("***** Resposta do servidor PHP", response.toString());

        JSONObject resposta_json = new JSONObject(response.toString());

        boolean login_realizado_com_sucesso = false;
        if (resposta_json.getString("acao").equals("consulta_rotina")) {

            if (resposta_json.getInt("resultado") == 1) {
                // ID= resposta_json.getInt("ID");
                nome = resposta_json.getString("nome");

                login_realizado_com_sucesso = true;
            }
        }


        if (login_realizado_com_sucesso)
            return true;
        else
            return false;
    }


    //Esta tarefa é assincrona - acessa o servidor remoto PHP e não trava a app android
    private class a extends AsyncTask<Void, Void, Integer> {

        boolean resposta;

        @Override
        protected Integer doInBackground(Void... voids) {

            try {
                resposta = b();
                if (resposta) {
                    return 1;
                } else {
                    return 0;
                }
            } catch (Exception e) {
                e.printStackTrace();
                return -1;
            }
            /*
            Eu estou considerando o seguinte:
            Retorno 1 para informar que login foi feito com sucesso
            Retorno 0 para informar que login estava incorreto
            Retorno -1, caso tenha ocorrido algum problema ao acessar o servidor
             */

        }


        //Utilizo isso apenas para atualizar os componentes da tela
        @Override
        protected void onPostExecute(Integer result) {


            switch (result) {
                case 0:
                    tvRespostaServidor.setText("Login incorreto. Tente novamente");
                    break;
                case 1:
                    nome="bbbbb";
                    break;
                case -1:
                    tvRespostaServidor.setText("Ocorreu um erro ao acessar o servidor");
            }
        }



    }

    private boolean conexao() throws Exception {

        URL obj = new URL(webservice.toString());
        HttpURLConnection con = (HttpURLConnection) obj.openConnection();

        //add request header
        con.setRequestMethod("POST");
        con.setDoOutput(true);


        //Gerando o objeto em JSON com os dados de login informados pelo usuario
        JSONObject acao = new JSONObject();
        JSONObject parametros = new JSONObject();


        acao.put("acao", "consulta_quant");
        acao.put("parametros", parametros);

        Log.i("***Enviando requisicao POST para servidor PHP: ", acao.toString());


        // Send post request
        con.setDoOutput(true);
        DataOutputStream wr = new DataOutputStream(con.getOutputStream());
        wr.writeBytes(acao.toString());
        wr.flush();
        wr.close();

        BufferedReader in = new BufferedReader(new InputStreamReader(con.getInputStream()));
        StringBuffer response = new StringBuffer();

        String inputLine;
        while ((inputLine = in.readLine()) != null) {
            response.append(inputLine);
        }
        in.close();

        //Imprimindo resultado recebido do servidor
        Log.i("***** Resposta do servidor PHP", response.toString());

        JSONObject resposta_json = new JSONObject(response.toString()); 

        boolean login_realizado_com_sucesso = false;
        if (resposta_json.getString("acao").equals("consulta_quant")) {
            if (resposta_json.getInt("resultado") == 1) {

                quant_rotina= resposta_json.getInt("quant_rotina");

                login_realizado_com_sucesso = true;


            }
        }


        if (login_realizado_com_sucesso)
            return true;
        else
            return false;
    }


    //Esta tarefa é assincrona - acessa o servidor remoto PHP e não trava a app android
    private class rotinas extends AsyncTask<Void, Void, Integer> {

        boolean respost;

        @Override
        protected Integer doInBackground(Void... voids) {

            try {
                respost = conexao();
                if (respost) {
                    return 1;
                } else {
                    return 0;
                }
            } catch (Exception e) {
                e.printStackTrace();
                return -1;
            }
            /*
            Eu estou considerando o seguinte:
            Retorno 1 para informar que login foi feito com sucesso
            Retorno 0 para informar que login estava incorreto
            Retorno -1, caso tenha ocorrido algum problema ao acessar o servidor
             */

        }


        //Utilizo isso apenas para atualizar os componentes da tela

    }





}



