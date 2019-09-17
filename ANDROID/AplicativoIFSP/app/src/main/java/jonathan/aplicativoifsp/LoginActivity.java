package jonathan.aplicativoifsp;

import android.content.Intent;
import android.os.AsyncTask;
import android.provider.Settings;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ProgressBar;
import android.widget.TextView;

import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.DataOutputStream;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;

public class LoginActivity extends AppCompatActivity {

    Button btn_login;
    Button btn_cadastro;
    String etCaminhoWebService;
    Integer rotina;
    EditText txt_email;
    EditText txt_senha;
    TextView tvRespostaServidor;
    ProgressBar progressBar;





    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);

        btn_login = (Button) findViewById(R.id.btn_login);
        btn_cadastro = (Button) findViewById(R.id.btn_cadastro);
        etCaminhoWebService = "http://192.168.43.48/Projeto/login/login_pac.php";
        txt_email = (EditText) findViewById(R.id.txt_email);
        txt_senha = (EditText) findViewById(R.id.txt_senha);
        tvRespostaServidor = (TextView) findViewById(R.id.tvRespostaServidor);
        progressBar = (ProgressBar) findViewById(R.id.progressBar);

        //inicializo a app com a progressbar escondida
        progressBar.setVisibility(View.GONE);



        btn_login.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {

                progressBar.setVisibility(View.VISIBLE);

                //chamo minha asynctask que vai contactar o servidor PHP
                new threadAssincronaParaAcessarServidor().execute();

            }
        });

        btn_cadastro.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {



                //chamo minha asynctask que vai contactar o servidor PHP
                setContentView(R.layout.activity_cadastro);


            }
        });


    }








    // Esta é funcao que possui a lógica para acessar o servidor PHP
    //Retorna TRUE se login feito com sucesso - FALSE, caso contrario
    private boolean enviarRequisicaoHTTPPost() throws Exception {

        URL obj = new URL(etCaminhoWebService.toString());
        HttpURLConnection con = (HttpURLConnection) obj.openConnection();

        //add request header
        con.setRequestMethod("POST");
        con.setDoOutput(true);


        //Gerando o objeto em JSON com os dados de login informados pelo usuario
        JSONObject acao = new JSONObject();
        JSONObject parametros = new JSONObject();

        parametros.put("usuario", txt_email.getText().toString());
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
        if(resposta_json.getString("acao").equals("efetuar_login")) {
            rotina = resposta_json.getInt("rotina");
            if (resposta_json.getInt("resultado") == 1) {

                login_realizado_com_sucesso = true;

            }

        }


        if(login_realizado_com_sucesso)
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
        @Override
        protected void onPostExecute(Integer result) {
            progressBar.setVisibility(View.GONE);

            switch (result) {
                case 0:
                    tvRespostaServidor.setText("Login incorreto. Tente novamente");
                    break;
                case 1:

                    MainActivity.id_rotina=rotina;
                    Intent i = new Intent(LoginActivity.this, MainActivity.class);
                    startActivity(i);
                    break;
                case -1:
                    tvRespostaServidor.setText("Ocorreu um erro ao acessar o servidor");
            }
        }

    }



}
