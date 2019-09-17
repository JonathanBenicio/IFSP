package jonathan.ifsp;

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

    Button btn_login;
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
    TextView tvRespostaServidor;
    ProgressBar progressBar;
    ListView lista;
    ArrayList<String> listarotina = new ArrayList<>();
    String[] rotina = new String[100];

    String quant_rotina;
    int aux;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_cadastro);

        btn_login = (Button) findViewById(R.id.btn_login);
        webservice = "http://192.168.0.21/Projeto/cadastro/tela_cadastro_pac.php";
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
        tvRespostaServidor = (TextView) findViewById(R.id.tvRespostaServidor);
        progressBar = (ProgressBar) findViewById(R.id.progressBar);

        lista = (ListView) findViewById(R.id.lista);

        ArrayList<String> rotina = preencherdados();

        ArrayAdapter<String> adapter = new ArrayAdapter<String>(this, android.R.layout.simple_list_item_1, rotina);
        lista.setAdapter(adapter);

    }

    private ArrayList<String> preencherdados() {

        new acessarsevidor().execute();

        ArrayList<String> dados = new ArrayList<String>();
        dados.add(quant_rotina);

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

        parametros.put("Nome", txt_nome.getText().toString());
        parametros.put("usuario", txt_email.getText().toString());
        parametros.put("cpf", txt_cpf.getText().toString());
        parametros.put("rg", txt_rg.getText().toString());
        parametros.put("idade", txt_idade.getText().toString());
        parametros.put("genero", txt_genero.getText().toString());
        parametros.put("telefone", txt_telefone.getText().toString());
        parametros.put("facebook", txt_facebook.getText().toString());
        parametros.put("instagram", txt_instagram.getText().toString());
        parametros.put("senha", txt_senha.getText().toString());

        acao.put("acao", "efetuar_login");
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
        if (resposta_json.getString("acao").equals("efetuar_login")) {
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
            progressBar.setVisibility(View.GONE);

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




    private boolean conexao() throws Exception {

        URL obj = new URL(webservice.toString());
        HttpURLConnection con = (HttpURLConnection) obj.openConnection();

        //add request header
        con.setRequestMethod("POST");
        con.setDoOutput(true);


        //Gerando o objeto em JSON com os dados de login informados pelo usuario
        JSONObject acao = new JSONObject();
        JSONObject parametros = new JSONObject();

        parametros.put("usuario", txt_email.getText().toString());
        parametros.put("senha", txt_senha.getText().toString());

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
        if(resposta_json.getString("acao").equals("consulta_quant")) {
            if (resposta_json.getInt("resultado") == 1) {
                quant_rotina=resposta_json.getString("acao");
                login_realizado_com_sucesso = true;
            }
        }


        if(login_realizado_com_sucesso)
            return true;
        else
            return false;
    }
    //Esta tarefa é assincrona - acessa o servidor remoto PHP e não trava a app android
    private class acessarsevidor extends AsyncTask<Void, Void, Integer> {

        boolean resposta;

        @Override
        protected Integer doInBackground(Void... voids) {

            try {
                resposta = conexao();
                if(resposta) {
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



