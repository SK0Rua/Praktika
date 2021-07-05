<?php
class ControllerSaleForma extends Controller {
    private $error = array();

    public function index() {
        $this->load->language('sale/forma');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('sale/forma');

        $this->getList();
    }

    protected function getList() {


        if (isset($this->request->get['forma'])) {
            $forma = $this->request->get['forma'];
        } else {
            $forma = 'DESC';
        }

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        $url = '';

        if (isset($this->request->get['forma'])) {
            $url .= '&forma=' . $this->request->get['forma'];
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('sale/forma', 'user_token=' . $this->session->data['user_token'] . $url, true)
        );

        $data['invoice'] = $this->url->link('sale/forma/invoice', 'user_token=' . $this->session->data['user_token'], true);
        $data['shipping'] = $this->url->link('sale/forma/shipping', 'user_token=' . $this->session->data['user_token'], true);
        $data['add'] = $this->url->link('sale/forma/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
        $data['delete'] = str_replace('&amp;', '&', $this->url->link('sale/forma/delete', 'user_token=' . $this->session->data['user_token'] . $url, true));

        $data['formas'] = array();

        $filter_data = array(
            'forma'                  => $forma,
            'start'                  => ($page - 1) * $this->config->get('config_limit_admin'),
            'limit'                  => $this->config->get('config_limit_admin')
        );

        $results = $this->model_sale_forma->getFormas($filter_data);

        foreach ($results as $result) {
            $data['formas'][] = array(
                'forma_id'      => $result['forma_id'],
                'firstname'      => $result['firstname'],
                'email'      => $result['email'],
                'telephone'      => $result['telephone'],
                'view'          => $this->url->link('sale/forma/info', 'user_token=' . $this->session->data['user_token'] . '&forma_id=' . $result['forma_id'] . $url, true),
                'edit'          => $this->url->link('sale/forma/edit', 'user_token=' . $this->session->data['user_token'] . '&forma_id=' . $result['forma_id'] . $url, true)
            );
        }

        $data['user_token'] = $this->session->data['user_token'];

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];

            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }

        if (isset($this->request->post['selected'])) {
            $data['selected'] = (array)$this->request->post['selected'];
        } else {
            $data['selected'] = array();
        }

        $url = '';



        if ($forma == 'ASC') {
            $url .= '&forma=DESC';
        } else {
            $url .= '&forma=ASC';
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }


        $url = '';

        if (isset($this->request->get['forma'])) {
            $url .= '&forma=' . $this->request->get['forma'];
        }

        $pagination = new Pagination();
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_limit_admin');
        $pagination->url = $this->url->link('sale/forma', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}', true);

        $data['pagination'] = $pagination->render();


        $data['forma'] = $forma;


        // API login
        $data['catalog'] = $this->request->server['HTTPS'] ? HTTPS_CATALOG : HTTP_CATALOG;

        // API login
        $this->load->model('user/api');

        $api_info = $this->model_user_api->getApi($this->config->get('config_api_id'));

        if ($api_info && $this->user->hasPermission('modify', 'sale/forma')) {
            $session = new Session($this->config->get('session_engine'), $this->registry);

            $session->start();

            $this->model_user_api->deleteApiSessionBySessonId($session->getId());

            $this->model_user_api->addApiSession($api_info['api_id'], $session->getId(), $this->request->server['REMOTE_ADDR']);

            $session->data['api_id'] = $api_info['api_id'];

            $data['api_token'] = $session->getId();
        } else {
            $data['api_token'] = '';
        }

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('sale/forma_list', $data));
    }
}
