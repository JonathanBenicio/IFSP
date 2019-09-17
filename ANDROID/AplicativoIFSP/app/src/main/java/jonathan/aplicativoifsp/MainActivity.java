package jonathan.aplicativoifsp;

import android.app.Fragment;
import android.content.Intent;
import android.os.AsyncTask;
import android.os.Bundle;
import android.support.design.widget.FloatingActionButton;
import android.support.design.widget.Snackbar;
import android.support.v4.app.FragmentActivity;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentTransaction;
import android.util.Log;
import android.view.View;
import android.support.design.widget.NavigationView;
import android.support.v4.view.GravityCompat;
import android.support.v4.widget.DrawerLayout;
import android.support.v7.app.ActionBarDrawerToggle;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.view.Menu;
import android.view.MenuItem;
import android.widget.EditText;
import android.widget.TextView;

import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.DataOutputStream;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;

public class MainActivity extends AppCompatActivity
        implements NavigationView.OnNavigationItemSelectedListener {

    public static Integer id_rotina;



    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);



        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        ActionBarDrawerToggle toggle = new ActionBarDrawerToggle(
                this, drawer, toolbar, R.string.navigation_drawer_open, R.string.navigation_drawer_close);
        drawer.addDrawerListener(toggle);
        toggle.syncState();

        NavigationView navigationView = (NavigationView) findViewById(R.id.nav_view);
        navigationView.setNavigationItemSelectedListener(this);


    }

    @Override
    public void onBackPressed() {
        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        if (drawer.isDrawerOpen(GravityCompat.START)) {
            drawer.closeDrawer(GravityCompat.START);
        } else {
            super.onBackPressed();
        }
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.main, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();

        //noinspection SimplifiableIfStatement
        if (id == R.id.action_settings) {
            return true;
        }

        return super.onOptionsItemSelected(item);
    }

    @SuppressWarnings("StatementWithEmptyBody")
    @Override
    public boolean onNavigationItemSelected(MenuItem item) {
        // Handle navigation view item clicks here.
        int id = item.getItemId();
        FragmentManager fragmentManager = getSupportFragmentManager();

        if (id == R.id.nav_atividade) {
            // Handle the camera action
            fragmentManager.beginTransaction().replace(R.id.fram, new AtividadeFragment()).commit();


        } else if (id == R.id.nav_gallery) {
            setContentView(R.layout.fragment_atividade);



        } else if (id == R.id.nav_slideshow) {

        } else if (id == R.id.nav_manage) {

        }

        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        drawer.closeDrawer(GravityCompat.START);
        return true;
    }



    //fragmento

    TextView txt_nome1;
    TextView txt_nome2;
    TextView txt_nome3;
    TextView txt_nome4;
    TextView txt_nome5;
    TextView txt_nome6;
    TextView txt_nome7;
    TextView txt_nome8;
    TextView txt_nome9;
    TextView txt_nome10;

    TextView txt_descricao1;
    TextView txt_descricao2;
    TextView txt_descricao3;
    TextView txt_descricao4;
    TextView txt_descricao5;
    TextView txt_descricao6;
    TextView txt_descricao7;
    TextView txt_descricao8;
    TextView txt_descricao9;
    TextView txt_descricao10;


    String webservice;

    String[] rotina;


        public void onFragmentViewCreated (View view){

            // Iniciar os campos buscando no layout do Fragment
            txt_nome1 = (TextView) view.findViewById(R.id.txt_nome1);
            txt_nome2 = (TextView) view.findViewById(R.id.txt_nome2);
            txt_nome3 = (TextView) view.findViewById(R.id.txt_nome3);
            txt_nome4 = (TextView) view.findViewById(R.id.txt_nome4);
            txt_nome5 = (TextView) view.findViewById(R.id.txt_nome5);
            txt_nome6 = (TextView) view.findViewById(R.id.txt_nome6);
            txt_nome7 = (TextView) view.findViewById(R.id.txt_nome7);
            txt_nome8 = (TextView) view.findViewById(R.id.txt_nome8);
            txt_nome9 = (TextView) view.findViewById(R.id.txt_nome9);
            txt_nome10 = (TextView) view.findViewById(R.id.txt_nome10);

            txt_descricao1 = (TextView) view.findViewById(R.id.txt_descricao1);
            txt_descricao2 = (TextView) view.findViewById(R.id.txt_descricao2);
            txt_descricao3 = (TextView) view.findViewById(R.id.txt_descricao3);
            txt_descricao4 = (TextView) view.findViewById(R.id.txt_descricao4);
            txt_descricao5 = (TextView) view.findViewById(R.id.txt_descricao5);
            txt_descricao6 = (TextView) view.findViewById(R.id.txt_descricao6);
            txt_descricao7 = (TextView) view.findViewById(R.id.txt_descricao7);
            txt_descricao8 = (TextView) view.findViewById(R.id.txt_descricao8);
            txt_descricao9 = (TextView) view.findViewById(R.id.txt_descricao9);
            txt_descricao10 = (TextView) view.findViewById(R.id.txt_descricao10);
            webservice = "http://192.168.0.21/Projeto/consulta/consulta_atividade.php";


            new MainActivity.threadAssincronaParaAcessarServido().execute();


        }

        private boolean enviarRequisicaoHTTPPost () throws Exception {


            URL obj = new URL(webservice.toString());
            HttpURLConnection con = (HttpURLConnection) obj.openConnection();

            //add request header
            con.setRequestMethod("POST");
            con.setDoOutput(true);


            //Gerando o objeto em JSON com os dados de login informados pelo usuario
            JSONObject acao = new JSONObject();
            JSONObject parametros = new JSONObject();
            JSONObject nome = new JSONObject();

            parametros.put("rotina_pac", id_rotina.toString());


            acao.put("acao", "consulta_atividade");
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
            if (resposta_json.getString("acao").equals("consulta_atividade")) {
                if (resposta_json.getInt("resultado") == 1) {
            //        txt_n1 = resposta_json.getString("n1");

                    login_realizado_com_sucesso = true;


                }
            }


            if (login_realizado_com_sucesso)
                return true;
            else
                return false;
        }


        //Esta tarefa é assincrona - acessa o servidor remoto PHP e não trava a app android
        private class threadAssincronaParaAcessarServido extends AsyncTask<Void, Void, Integer> {

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

                        break;
                    case 1:
                  //      txt_nome1.setText(txt_n1);
                        //      txt_nome2.setText(txt_n2);
                        //txt_nome3.setText(txt_n3);
                        //txt_nome4.setText(txt_n4);
                        //txt_nome5.setText(txt_n5);
                        //txt_nome6.setText(txt_n6);
                        //txt_nome7.setText(txt_n7);
                        //txt_nome8.setText(txt_n8);
                        //txt_nome9.setText(txt_n9);
                        //txt_nome10.setText(txt_n10);

                        //txt_descricao1.setText(txt_d1);
                        //txt_descricao2.setText(txt_d2);
                        //txt_descricao3.setText(txt_d3);
                        //txt_descricao4.setText(txt_d4);
                        //txt_descricao5.setText(txt_d5);
                        //txt_descricao6.setText(txt_d6);
                        //txt_descricao7.setText(txt_d7);
                        //txt_descricao8.setText(txt_d8);
                        //txt_descricao9.setText(txt_d9);
                        //txt_descricao10.setText(txt_d10);
                        break;
                    case -1:
                        txt_nome1.setText("aaaaa");
                }
            }

        }

}
