BEGIN;
DROP TABLE IF EXISTS public.sale_item;

DROP TABLE IF EXISTS public.sale;

DROP TABLE IF EXISTS public.product;

DROP TABLE IF EXISTS public.product_type;

CREATE TABLE IF NOT EXISTS public.product
(
    id serial,
    name character varying(100) NOT NULL,
    barcode character varying(20) NOT NULL,
    description character varying(255),
    price numeric(18, 2) NOT NULL,
    product_type_id integer NOT NULL,
    created_at timestamp without time zone NOT NULL,
    updated_at timestamp without time zone NOT NULL,
    CONSTRAINT product_pkey PRIMARY KEY (id),
    CONSTRAINT uq_barcode_product UNIQUE (barcode)
);


CREATE TABLE IF NOT EXISTS public.product_type
(
    id serial,
    name character varying(100) NOT NULL,
    tax_percentage numeric(8, 3) NOT NULL,
    CONSTRAINT product_type_pkey PRIMARY KEY (id),
    CONSTRAINT uq_name_product_type UNIQUE (name)
);

CREATE TABLE IF NOT EXISTS public.sale
(
    id bigserial,
    total_product_value numeric(18, 2) NOT NULL,
    total_tax_value numeric(18, 2) NOT NULL,
    created_at timestamp without time zone NOT NULL,
    updated_at timestamp without time zone NOT NULL,
    CONSTRAINT sale_pkey PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS public.sale_item
(
    id bigserial,
    product_id integer NOT NULL,
    sale_id bigint NOT NULL,
    item_number integer NOT NULL,
    sold_amount numeric(18, 4) NOT NULL,
    product_value numeric(18, 2) NOT NULL,
    tax_value numeric(18, 2) NOT NULL,
    PRIMARY KEY (id)
);

ALTER TABLE IF EXISTS public.product
    ADD CONSTRAINT fk_product_type_product FOREIGN KEY (product_type_id)
    REFERENCES public.product_type (id) MATCH SIMPLE
    ON UPDATE NO ACTION
    ON DELETE NO ACTION
    NOT VALID;


ALTER TABLE IF EXISTS public.sale_item
    ADD CONSTRAINT fk_product_sale_item FOREIGN KEY (product_id)
    REFERENCES public.product (id) MATCH SIMPLE
    ON UPDATE NO ACTION
    ON DELETE NO ACTION
    NOT VALID;


ALTER TABLE IF EXISTS public.sale_item
    ADD CONSTRAINT fk_sale_sale_item FOREIGN KEY (sale_id)
    REFERENCES public.sale (id) MATCH SIMPLE
    ON UPDATE NO ACTION
    ON DELETE NO ACTION
    NOT VALID;


END;