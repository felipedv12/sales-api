--
-- PostgreSQL database dump
--

-- Dumped from database version 15.2
-- Dumped by pg_dump version 15.2

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: product; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.product (
    id integer NOT NULL,
    name character varying(100) NOT NULL,
    barcode character varying(20) NOT NULL,
    description character varying(255),
    price numeric(18,2) NOT NULL,
    product_type_id integer NOT NULL,
    created_at timestamp without time zone NOT NULL,
    updated_at timestamp without time zone NOT NULL
);


ALTER TABLE public.product OWNER TO postgres;

--
-- Name: product_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.product_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.product_id_seq OWNER TO postgres;

--
-- Name: product_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.product_id_seq OWNED BY public.product.id;


--
-- Name: product_type; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.product_type (
    id integer NOT NULL,
    name character varying(100) NOT NULL,
    tax_percentage numeric(8,3) NOT NULL
);


ALTER TABLE public.product_type OWNER TO postgres;

--
-- Name: product_type_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.product_type_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.product_type_id_seq OWNER TO postgres;

--
-- Name: product_type_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.product_type_id_seq OWNED BY public.product_type.id;


--
-- Name: sale; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sale (
    id bigint NOT NULL,
    total_product_value numeric(18,2) NOT NULL,
    total_tax_value numeric(18,2) NOT NULL,
    created_at timestamp without time zone NOT NULL,
    updated_at timestamp without time zone NOT NULL
);


ALTER TABLE public.sale OWNER TO postgres;

--
-- Name: sale_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.sale_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sale_id_seq OWNER TO postgres;

--
-- Name: sale_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.sale_id_seq OWNED BY public.sale.id;


--
-- Name: sale_item; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sale_item (
    id bigint NOT NULL,
    product_id integer NOT NULL,
    sale_id bigint NOT NULL,
    item_number integer NOT NULL,
    sold_amount numeric(18,4) NOT NULL,
    product_value numeric(18,2) NOT NULL,
    tax_value numeric(18,2) NOT NULL
);


ALTER TABLE public.sale_item OWNER TO postgres;

--
-- Name: sale_item_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.sale_item_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sale_item_id_seq OWNER TO postgres;

--
-- Name: sale_item_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.sale_item_id_seq OWNED BY public.sale_item.id;


--
-- Name: product id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.product ALTER COLUMN id SET DEFAULT nextval('public.product_id_seq'::regclass);


--
-- Name: product_type id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.product_type ALTER COLUMN id SET DEFAULT nextval('public.product_type_id_seq'::regclass);


--
-- Name: sale id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sale ALTER COLUMN id SET DEFAULT nextval('public.sale_id_seq'::regclass);


--
-- Name: sale_item id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sale_item ALTER COLUMN id SET DEFAULT nextval('public.sale_item_id_seq'::regclass);


--
-- Data for Name: product; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.product (id, name, barcode, description, price, product_type_id, created_at, updated_at) FROM stdin;
6	Patinho	788573516467		25.00	1	2023-04-21 15:45:01.009155	2023-04-21 15:45:01.009155
8	Alcatra	788573516465		20.00	1	2023-04-21 23:10:00.933899	2023-04-21 23:23:21.981175
9	Peixinho	788573516468		25.00	1	2023-04-22 01:04:44.612304	2023-04-22 01:04:44.612304
\.


--
-- Data for Name: product_type; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.product_type (id, name, tax_percentage) FROM stdin;
1	Carne	23.990
2	Bebida alcoólica	55.600
5	Arroz	10.000
\.


--
-- Data for Name: sale; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.sale (id, total_product_value, total_tax_value, created_at, updated_at) FROM stdin;
6	325.00	77.97	2023-04-22 02:01:28.436786	2023-04-22 02:01:28.436929
16	410.00	98.36	2023-04-24 08:42:17.442554	2023-04-24 08:42:17.442667
\.


--
-- Data for Name: sale_item; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.sale_item (id, product_id, sale_id, item_number, sold_amount, product_value, tax_value) FROM stdin;
1	8	6	1	10.0000	200.00	47.98
2	6	6	2	5.0000	125.00	29.99
3	9	16	1	10.0000	250.00	59.98
4	8	16	2	8.0000	160.00	38.38
\.


--
-- Name: product_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.product_id_seq', 11, true);


--
-- Name: product_type_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.product_type_id_seq', 5, true);


--
-- Name: sale_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.sale_id_seq', 16, true);


--
-- Name: sale_item_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.sale_item_id_seq', 4, true);


--
-- Name: product product_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.product
    ADD CONSTRAINT product_pkey PRIMARY KEY (id);


--
-- Name: product_type product_type_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.product_type
    ADD CONSTRAINT product_type_pkey PRIMARY KEY (id);


--
-- Name: sale_item sale_item_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sale_item
    ADD CONSTRAINT sale_item_pkey PRIMARY KEY (id);


--
-- Name: sale sale_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sale
    ADD CONSTRAINT sale_pkey PRIMARY KEY (id);


--
-- Name: product uq_barcode_product; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.product
    ADD CONSTRAINT uq_barcode_product UNIQUE (barcode);


--
-- Name: product_type uq_name_product_type; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.product_type
    ADD CONSTRAINT uq_name_product_type UNIQUE (name);


--
-- Name: sale_item fk_product_sale_item; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sale_item
    ADD CONSTRAINT fk_product_sale_item FOREIGN KEY (product_id) REFERENCES public.product(id) NOT VALID;


--
-- Name: product fk_product_type_product; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.product
    ADD CONSTRAINT fk_product_type_product FOREIGN KEY (product_type_id) REFERENCES public.product_type(id) NOT VALID;


--
-- Name: sale_item fk_sale_sale_item; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sale_item
    ADD CONSTRAINT fk_sale_sale_item FOREIGN KEY (sale_id) REFERENCES public.sale(id) NOT VALID;


--
-- PostgreSQL database dump complete
--

